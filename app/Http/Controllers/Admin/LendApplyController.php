<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Account;
use App\LendRecord;
use App\Repositories\LendRecords;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use App\Repositories\AuthCodes;
use Validator;
use App\User;
use Response;
use Sentinel;

class LendApplyController extends Controller
{
    public function index()
    {
        $companies = User::all()->where('company_service_id', '<>', null);

        // Show the page
        return view('admin.trade.lendApply', compact('companies'));
    }

    public function getLendInfo(AuthCodes $authCodes)
    {
        $user = User::find(request()->id);

        $data = $authCodes->getMoneyRecord($user);

        $data += ['accounts' => $user->accounts->toArray()];

        return $data;
    }

    public function apply(Request $request, AuthCodes $authCodes)
    {
        $messages = [
            'required' => ':attribute 是必填资讯.',
            'exists'   => '此银行卡不存在，请刷新页面后重试.',
            'integer'  => '请输入有效:attribute，应由数字构成',
        ];

        $validator = Validator::make( $request->toArray(), [
            'client' => 'required|exists:users,id',
            'amount' => 'required|integer',
            'account' => 'required|integer|exists:accounts,id'
        ], $messages);

        if ($validator->fails())
            return $this->validateErrorResponseInJson($validator);

        $client = User::find($request->client);
        $account = Account::find($request->account);
        if($account->user_id != $client->id)
            return Response::json(array(
                'Result' => 'error',
                'Message'=> '此银行卡持有厂商与要求不符，请联络客服人员'
            ));

        $data = $authCodes->getMoneyRecord($client);

        if($request->amount > $data['totalIncome'])
            return Response::json(array(
                'Result' => 'error',
                'Message'=> '申请金额超过可下发馀额，请联络客服人员'
            ));

        $client->addLendRecord(new LendRecord([
            'record_seq' => $seq = Carbon::now('Asia/Taipei')->format('YmdHis'),
            'account_id' => $request->account,
            'amount' => $request->amount,
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
        if(isset(request()->companyId)){
            $user = User::find(request()->companyId);

            $lendRecords = $lendRecords->getUserRecords($user, request()->startDate, request()->endDate);
        }else{
            $lendRecords = [];
        }

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
                $infoLink = '<a href='. route('admin.lendApply.showRecord', ['lendRecord' => $lendRecord->id]) .' data-toggle="modal" data-target="#lend_info"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('Trade/LendManage/form.manage') . '></i></a>';

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
