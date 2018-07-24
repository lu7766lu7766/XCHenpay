<?php

namespace App\Http\Controllers\Admin;

use App\Account;
use App\Http\Controllers\Controller;
use App\LendRecord;
use Yajra\DataTables\DataTables;
use App\Repositories\AuthCodes;
use Illuminate\Http\Request;
use App\Authcode;
use Validator;
use App\User;
use Response;
use Sentinel;

class LendingController extends Controller
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
            'account_id' => $request->account,
            'amount' => $request->amount,
            'fee'    => 0,
            'lend_state' => 0,
            'lend_summary' => '下发中',
            'description' => $request->description
        ]));

        $user = Sentinel::getUser();
        activity($user->email)
            ->causedBy($user)
            ->log('申请下发'.$request->amount.'元入'.$request->account);

        return array('Result' => 'OK');
    }

    public function data()
    {
        $startDate = request()->startDate . ' 00:00:00';
        $endDate = request()->endDate . ' 23:59:59';

        $lendRecords = LendRecord::where('user_id', '=', request()->companyId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('account')
            ->get();

        return $this->makeatatable($lendRecords);
    }

    private function makeatatable($lendRecords)
    {
        return DataTables::of($lendRecords)
            ->addColumn('account_name',function($lendRecord){
                return $lendRecord->account->name;
            })
            ->addColumn('account_seq',function($lendRecord){
                return $lendRecord->account->account;
            })
            ->addColumn('bank_name',function($lendRecord){
                return $lendRecord->account->bank_name;
            })
            ->addColumn('account_branch',function($lendRecord){
                return $lendRecord->account->bank_branch;
            })
            ->make(true);
    }
}
