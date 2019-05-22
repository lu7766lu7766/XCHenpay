<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Order\OrderStatusConstants;
use App\Constants\Roles\RolesConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthCodeBankCardAccountInfoRequest;
use App\Http\Requests\AuthCodeOrderNotifyRequest;
use App\Http\Requests\AuthCodeOrderSearchRequest;
use App\Models\Authcode;
use App\Models\PaymentFees;
use App\Policies\OrderQueryPolicy;
use App\Repositories\AuthCodes;
use App\Repositories\UserRepo;
use App\Service\AuthCodeService;
use App\Service\OrderService;
use App\Service\PaymentService;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Response;
use Sentinel;
use Validator;

class AuthcodeController extends Controller
{
    public function index()
    {
        return view('admin.trade.logQuery', compact('companies', 'switchPromission', 'notifyUrl'));
    }

    public function dataInit()
    {
        $user = Sentinel::getUser();
        $switchPromission = $user->hasAccess('users.dataSwitch');
        if ($switchPromission) {
            $companies = app(UserRepo::class)->getCompanies();
        }

        return [
            "companies" => $companies ?? [],
            "user"      => $user
        ];
    }

    /**
     * @param AuthCodeOrderSearchRequest $request
     * @param AuthCodes $authCodes
     * @return array
     */
    public function data(AuthCodeOrderSearchRequest $request)
    {
        /** @var User $user */
        $user = Sentinel::getUser();
        $isMerchant = $user->inRole(RolesConstants::USER);
        $authCodeRepo = app(AuthCodes::class);
        $bankCardCondition = $user->getKey();
        $company = $user->getKey();
        // 如果有擁有可選擇商戶的權限
        if ($user->hasAccess('users.dataSwitch') && !$isMerchant) {
            $bankCardCondition = null;
            $company = $request->getTargetId();
        }
        $order = $authCodeRepo->list(
            $request->getStatTime(),
            $request->getEndTime(),
            $company,
            $request->getPage(),
            $request->getPerpage(),
            $request->getPayState(),
            $request->getKeyword(),
            $request->getPaymentType(),
            $request->getSort(),
            $request->getDirection()
        );
        $order->load([
            'bankCardAccount' => function (BelongsToMany $query) use ($bankCardCondition) {
                if (!is_null($bankCardCondition)) {
                    $query->whereHas('personal', function (Builder $q) use ($bankCardCondition) {
                        $q->where('users.id', $bankCardCondition);
                    });
                }
                $query->with('payment');
            }
        ]);
        $can_edit = $user->hasAccess('logQuery') || ($user->hasAccess('logQuery.showState') &&
                $user->hasAccess('logQuery.updateState'));

        return [
            'data'     => $order,
            'can_edit' => $can_edit
        ];
    }

    /**
     * 注單資訊
     * @param Authcode $authcode
     * @return array
     */
    public function showInfo(Authcode $authcode)
    {
        $order = null;
        /** @var User $user */
        $user = Sentinel::getUser();
        if ($user->can('manage', OrderQueryPolicy::class)
            || $authcode->company_service_id == $user->company_service_id) {
            $order = $authcode;
            $order->load(['currency', 'tradeType']);
        }

        return [
            'authcode' => $order
        ];
    }

    public function showFeeInfo($id)
    {
        $payment = PaymentFees::from('payment_fees as f')
            ->select('f.id', 'p.i6pay_id', 'p.name', 'f.fee', 'f.status')
            ->join('payments as p', 'p.id', '=', 'f.payment_id')
            ->where('f.id', $id)
            ->first();

//        return view('admin.trade.showFeeModal', compact('payment'));
        return [
            'payment' => $payment
        ];
    }

    public function editFeeInfo($id)
    {
        $payment = PaymentFees::from('payment_fees as f')
            ->select('f.id', 'p.i6pay_id', 'p.name', 'f.status', 'f.fee')
            ->join('payments as p', 'p.id', '=', 'f.payment_id')
            ->where('f.id', $id)
            ->first();

//        return view('admin.trade.editFeeModal', compact('payment'));
        return [
            'payment' => $payment
        ];
    }

    public function updateFeeInfo()
    {
        $user = Sentinel::getUser();
        $paymentFee = PaymentFees::find(request()->id);
        $paymentFee->fee = request()->fee;
        $paymentFee->status = request()->status;
        $logMsg = [];
        $logFlag = false;
        if ($paymentFee->isDirty('fee')) {
            $logMsg[] = $paymentFee->payment->name . ':' . $paymentFee->getOriginal('fee') . ' > ' . $paymentFee->fee;
            $logFlag = true;
        }
        if ($paymentFee->isDirty('status')) {
            $logMsg[] = '狀態:' . $paymentFee->getOriginal('status') . ' > ' . $paymentFee->status;
            $logFlag = true;
        }
        if ($logFlag) {
            activity($user->email)
                ->performedOn($paymentFee)
                ->causedBy($user)
                ->log('修改' . implode(',', $logMsg));
        }
        $paymentFee->save();
    }

    /**
     * @param AuthCodeOrderNotifyRequest $request
     * @return array
     */
    public function callNotify(AuthCodeOrderNotifyRequest $request)
    {
        return ['data' => OrderService::getInstance(Sentinel::getUser())->callNotify($request)];
    }

    /**
     * 單筆資訊
     * @param Authcode $authcode
     * @return array
     */
    public function showState(Authcode $authcode)
    {
        return [
            'authcode'  => $authcode,
            'stateList' => OrderStatusConstants::summaryMap()
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateState(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'id'               => 'required|integer|exists:authcodes,id',
            'state'            => 'required|integer|' . Rule::in(OrderStatusConstants::fillOrderEnum()),
            'pay_end_time'     => 'sometimes|required|date_format:"Y-m-d H:i:s"',
            'real_paid_amount' => 'required|numeric|min:0'
        ]);
        if ($validator->fails()) {
            return Response::json($validator->messages());
        }
        $user = Sentinel::getUser();
        /** @var Authcode $order */
        $order = Authcode::query()->find($request->get('id'));
        $oldState = $order->pay_summary;
        $order->pay_state = $request->get('state');
        $order->pay_summary = OrderStatusConstants::toSummary($request->state);
        $order->real_paid_amount = $request->get('real_paid_amount');
        if (!is_null($request->get('pay_end_time'))) {
            $order->pay_end_time = $request->get('pay_end_time');
        }
        $order->manual_at = date('Y-m-d H:i:s');
        $order->save();
        activity($user->email)
            ->causedBy($user)
            ->log('修改订单:' . $order->trade_seq . ' 状态,由"' . $oldState . '"修改至"' . $order->pay_summary . '"');

        return Response::json($order);
    }

    /**
     * @return array
     */
    public function payment()
    {
        return ['data' => PaymentService::getInstance()->all()];
    }

    /**
     * 取得當日交易資訊(交易成功金額,手續費,筆數)
     * @return array
     */
    public function tradeInfoOnToday()
    {
        return AuthCodeService::getInstance(Sentinel::getUser())->tradeInfoOnToday();
    }

    /**
     * 訂單交易資訊
     * @param AuthCodeOrderSearchRequest $request
     * @return Authcode
     */
    public function orderTradeInfo(AuthCodeOrderSearchRequest $request)
    {
        return AuthCodeService::getInstance(Sentinel::getUser())->orderTradeInfo($request);
    }

    /**
     * 商戶注單總數
     * @param AuthCodeOrderSearchRequest $request
     * @return int
     */
    public function dataTotal(AuthCodeOrderSearchRequest $request)
    {
        return AuthCodeService::getInstance(Sentinel::getUser())->total($request);
    }

    /**
     * @param $id
     * @return \App\Models\BankCardAccount
     * @throws ValidationException
     */
    public function bankCardAccountInfo($id)
    {
        return AuthCodeService::getInstance(Sentinel::getUser())->bankCardAccountInfo(
            AuthCodeBankCardAccountInfoRequest::getHandle(['bank_card_id' => $id])
        );
    }
}
