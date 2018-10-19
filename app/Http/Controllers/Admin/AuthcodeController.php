<?php

namespace App\Http\Controllers\Admin;

use App\Authcode;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthCodeOrderSearchRequest;
use App\Models\PaymentFees;
use App\Payment;
use App\Repositories\AuthCodes;
use App\User;
use Curl\Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Response;
use Sentinel;
use Validator;
use Yajra\DataTables\DataTables;

class AuthcodeController extends Controller
{
    public function index()
    {
        $user = Sentinel::getUser();
        $switchPromission = $user->hasAccess('users.dataSwitch');
        if ($switchPromission) {
            $companies = User::All()->where('company_service_id', '<>', null);
        }

        return view('admin.trade.logQuery', compact('companies', 'switchPromission', 'notifyUrl'));
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
        [$authCode, $totalRecords, $fee, $amount] = $authCodes->companyDataWithReport(
            $company,
            $request->get('start'),
            $request->get('end'),
            $request->get('page', 1),
            $request->get('perpage', 20),
            $request->get('pay_state'),
            $request->get('keyword'),
            $request->get('payment_type')
        );
        $result = [
            'data'   => $authCode->all(),
            'total'  => $totalRecords,
            'fee'    => $fee,
            'amount' => $amount
        ];

        return $result;
    }

    public function showInfo(Authcode $authcode)
    {
        return view('admin.trade.showTradeLogModal', compact('authcode'));
    }

    public function feeData()
    {
        $payments = [];
        if (isset(request()->company)) {
            $id = request()->company;
            $paysCount = Payment::where('id', '>', 1)->count();
            $paymentsSQL = PaymentFees::from('payment_fees as f')
                ->select('f.id', 'p.i6pay_id', 'p.name', 'f.fee', 'f.status', 'p.id as pid')
                ->join('payments as p', 'p.id', '=', 'f.payment_id')
                ->where('f.user_id', $id);
            $payments = $paymentsSQL->get();
            /* 檢查 payments 是否有新通道 */
            if (count($payments) != $paysCount) {
                $payment = Payment::select('id as payment_id', 'fee')
                    ->where('id', '>', 1)
                    ->get()
                    ->keyBy('payment_id');
                $diff = $payment->pluck('payment_id')->diff($payments->pluck('pid'));
                $diffData = [];
                foreach ($diff as $d) {
                    $p = $payment[$d];
                    $diffData[] = [
                        'payment_id' => $p->payment_id,
                        'fee'        => $p->fee
                    ];
                }
                $user = User::find($id);
                $user->fees()->createMany($diffData);
                $payments = $paymentsSQL->get();
            }
        }

        return $this->makeFeeDatatable($payments);
    }

    private function makeFeeDatatable($payments)
    {
        return DataTables::of($payments)
            ->editColumn('fee', function ($payment) {
                return $payment->fee . '%';
            })
            ->editColumn('status', function ($payment) {
                return ($payment->status == 1) ? trans('Trade/LendManage/form.status_enable') : trans('Trade/LendManage/form.status_disable');
            })
            ->addColumn('actions', function ($payment) {
                $infoLink = '<a href=' . route('admin.authcode.showFeeInfo',
                        ['payment' => $payment->id]) . ' data-toggle="modal" data-target="#show_FeeInfo"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="通道讯息"></i></a>';
                $editLink = '<a href=' . route('admin.authcode.editFeeInfo',
                        ['payment' => $payment->id]) . ' data-toggle="modal" data-target="#edit_FeeInfo"><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="编辑通道"></i></a>';
                $action = $infoLink;
                $user = Sentinel::getUser();
                if ($user->hasAccess('logQuery') || ($user->hasAccess('logQuery.editFeeInfo') && $user->hasAccess('logQuery.updateFeeInfo'))) {
                    $action .= $editLink;
                }

                return $action;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function showFeeInfo($id)
    {
        $payment = PaymentFees::from('payment_fees as f')
            ->select('f.id', 'p.i6pay_id', 'p.name', 'f.fee', 'f.status')
            ->join('payments as p', 'p.id', '=', 'f.payment_id')
            ->where('f.id', $id)
            ->first();

        return view('admin.trade.showFeeModal', compact('payment'));
    }

    public function editFeeInfo($id)
    {
        $payment = PaymentFees::from('payment_fees as f')
            ->select('f.id', 'p.i6pay_id', 'p.name', 'f.status', 'f.fee')
            ->join('payments as p', 'p.id', '=', 'f.payment_id')
            ->where('f.id', $id)
            ->first();

        return view('admin.trade.editFeeModal', compact('payment'));
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

    public function callNotify()
    {
        $user = Sentinel::getUser();
        if (!$user->hasAccess('users.dataSwitch') && $user->tradeLogs()->where('id', '=',
                request()->id)->first() == null) {
            $this->errorLog($user->email . '手动回调一笔不属于齐权限的订单: ' . request()->id);

            return $this->errorResponse('请求发生错误，请联络客服人员');
        }
        if (env('APP_inLocal')) {
            $notifyUrl = 'http://ThirdPPAPI.test/api/v1.0/notifyAgain';
        } else {
            $notifyUrl = 'http://' . request()->getHost() . '/ThirdPartyPayAPI/public/api/v1.0/notifyAgain';
        }
        $notify = new Curl();
        $notify->get($notifyUrl . '/' . request()->id);
        $response = $notify->response;
        if ($notify->error) {
            return $this->errorResponse('与服务器沟通错误，请联络客服人员');
        }
        if ($response != 'success') {
            return $this->errorResponse('回调失败，请联络客服人员');
        }

        //success
        return Response::json([
            'Result' => 'OK'
        ]);
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

        return view('admin.trade.stateEditModal', compact('authcode', 'stateList'));
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
}
