<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthCodeOrderNotifyRequest;
use App\Http\Requests\AuthCodeOrderSearchRequest;
use App\Models\Authcode;
use App\Models\PaymentFees;
use App\Repositories\AuthCodes;
use App\Repositories\UserRepo;
use App\Service\AuthCodeService;
use App\Service\OrderService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
            "can_show_company" => !!$switchPromission,
            "can_edit_fee"     => $user->hasAccess('logQuery.editFeeInfo') || $user->hasAccess('logQuery'),
            "can_edit_order"   => $user->hasAccess('logQuery.showState') || $user->hasAccess('logQuery'),
            "companies"        => $companies ?? [],
            "user"             => $user
        ];
    }

    /**
     * @param AuthCodeOrderSearchRequest $request
     * @param AuthCodes $authCodes
     * @return array
     */
    public function data(AuthCodeOrderSearchRequest $request, AuthCodes $authCodes)
    {
        /** @var User $user */
        $user = Sentinel::getUser();
        $company = $user->getKey();
        // 如果有擁有可選擇商戶的權限
        if ($user->hasAccess('users.dataSwitch')) {
            $company = $request->get('company', $company);
        }
        /** @var Collection $authCode */
        $authCode = $authCodes->companyDataWithReport(
            $company,
            $request->get('start'),
            $request->get('end'),
            $request->get('page', 1),
            $request->get('perpage', 20),
            $request->get('pay_state'),
            $request->get('keyword'),
            $request->get('payment_type', 0),
            $request->get('sort', 'created_at'),
            $request->get('direction', 'desc')
        );
        $can_edit = $user->hasAccess('logQuery') || ($user->hasAccess('logQuery.showState') &&
                $user->hasAccess('logQuery.updateState'));
        $result = [
            'data'     => $authCode,
            'can_edit' => $can_edit
        ];

        return $result;
    }

    public function showInfo(Authcode $authcode)
    {
//        return view('admin.trade.showTradeLogModal', compact('authcode'));
        $authcode->load(['currency', 'tradeType']);

        return [
            'authcode' => $authcode
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
        return ['data' => OrderService::getInstance()->callNotify($request)];
    }

    public function showState(Authcode $authcode)
    {
        $stateList = [
            0 => '申请成功',
            1 => '交易中',
            2 => '交易成功,未回调',
            3 => '交易结束',
            4 => '交易失败'
        ];

//        return view('admin.trade.stateEditModal', compact('authcode', 'stateList'));
        return [
            'authcode'  => $authcode,
            'stateList' => $stateList
        ];
    }

    public function updateState(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'id'    => 'required|integer|exists:authcodes,id',
            'state' => 'required|integer|in:0,1,2,3,4'
        ]);
        if ($validator->fails()) {
            return Response::json($validator->messages());
        }
        $user = Sentinel::getUser();
        $stateList = [
            0 => '申请成功',
            1 => '交易中',
            2 => '交易成功,未回调',
            3 => '交易结束',
            4 => '交易失败'
        ];
        $authcode = Authcode::find($request->id);
        $oldState = $authcode->pay_summary;
        $authcode->pay_state = $request->state;
        $authcode->pay_summary = $stateList[$request->state];
        $authcode->manual_at = date('Y-m-d H:i:s');
        $authcode->save();
        activity($user->email)
            ->causedBy($user)
            ->log('修改订单:' . $authcode->trade_seq . ' 状态,由"' . $oldState . '"修改至"' . $authcode->pay_summary . '"');

        return Response::json($authcode);
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
}
