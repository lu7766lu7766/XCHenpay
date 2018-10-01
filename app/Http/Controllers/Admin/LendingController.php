<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Account;
use App\LendRecord;
use App\Repositories\AuthCodes;
use App\Repositories\LendRecords;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Validator;
use Response;
use Sentinel;

class LendingController extends Controller
{
    public function index()
    {
        return view('admin.trade.showLending');
    }

    public function getInfo(AuthCodes $authCodes)
    {
        $user = Sentinel::getUser();

        $data = $authCodes->getMoneyRecord($user);

        $data += ['accounts' => $user->accounts->toArray()];

        return $data;
    }

    public function getUserInfo(AuthCodes $authCodes)
    {
        $user = Sentinel::getUser();

        return $user;
    }

    public function apply(Request $request, AuthCodes $authCodes)
    {
        $messages = [
            'required' => ':attribute 是必填资讯.',
            'exists'   => '此银行卡不存在，请刷新页面后重试.',
            'integer'  => '请输入有效:attribute，应由数字构成',
        ];

        $validator = Validator::make( $request->toArray(), [
            'amount' => 'required|integer',
            'account' => 'required|integer|exists:accounts,id'
        ], $messages);

        if ($validator->fails())
            return $this->validateErrorResponseInJson($validator);

        /*
         * 下发金额不可小于及大于设定值
         */
        if ($request->amount < config('constants.apply.min') || $request->amount > config('constants.apply.max')) {
            return Response::json([
                'Result'  => 'error',
                'Message' => '下发金额填写错误, 请重新输入'
            ]);
        }

        $client = Sentinel::getUser();
        $account = Account::find($request->account);

        if ($client->apply_status != 'on')
            return Response::json(array(
                'Result' => 'error',
                'Message'=> '您无下发申请之权限，请联络客服人员'
            ));

        if($account->user_id != $client->id)
            return Response::json(array(
                'Result' => 'error',
                'Message'=> '此银行卡持有厂商与要求不符，请联络客服人员'
            ));

        $data = $authCodes->getMoneyRecord($client);

        $fee = $request->amount * $client->lend_fee;
        $applyAmount = $request->amount + $fee;

        if($applyAmount > filter_var($data['totalIncome'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION))
            return Response::json(array(
                'Result' => 'error',
                'Message'=> '申请金额超过可下发馀额，请联络客服人员'
            ));

        $client->addLendRecord(new LendRecord([
            'record_seq' => $seq = Carbon::now('Asia/Taipei')->format('YmdHis'),
            'account_id' => $request->account,
            'amount' => $applyAmount,
            'fee'    => $request->amount * $client->lend_fee,
            'lend_state' => LendRecords::APPLY_STATE,
            'lend_summary' => LendRecords::APPLY_SUMMARY,
            'description' => (isset($request->description)) ? $request->description : ""
        ]));

        $user = Sentinel::getUser();
        activity($user->email)
            ->causedBy($user)
            ->log('提交一笔下发申请，单号：'. $seq);

        return array('Result' => 'OK');
    }

    public function data(LendRecords $lendRecords)
    {
        $user_id = Sentinel::getUser()->id;

        $lendRecords = $lendRecords->getUserRecords($user_id, request()->startDate, request()->endDate);

        return $this->makeDataTable($lendRecords);
    }

    private function makeDataTable($lendRecords)
    {
        return DataTables::of($lendRecords)
            ->addColumn('account_name',function($lendRecord){
                return $lendRecord->account->name;
            })
            ->addColumn('account',function($lendRecord){
                return $lendRecord->account->account;
            })
            ->addColumn('tatol_amount',function($lendRecord){
                return $lendRecord->amount - $lendRecord->fee;
            })
            ->addColumn('actions',function($lendRecord){
                $infoLink = '<a href='. route('admin.showLending.showRecord', ['lendRecord' => $lendRecord->id]) .' data-toggle="modal" data-target="#lend_info"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('Trade/LendManage/form.manage') . '></i></a>';

                return $infoLink;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function showRecordDialog(LendRecord $lendRecord){
        $account = $lendRecord->account;

        return view('admin.trade.showRecordModal', compact('lendRecord', 'account'));
    }


}
