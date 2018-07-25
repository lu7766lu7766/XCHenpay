<?php

namespace App\Http\Controllers\Admin;

use App\LendRecord;
use App\Repositories\AuthCodes;
use App\Repositories\LendRecords;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Authcode;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Validator;
use Response;

class LendManageController extends Controller
{
    public function index()
    {
        // Show the page
        return view('admin.trade.lendManage');
    }

    public function data(LendRecords $lendRecords)
    {
        $user = User::find(request()->companyId);

        $lendRecords = $lendRecords->getUserRecords($user, request()->startDate, request()->endDate);

        dd($lendRecords);
        return $this->makeDataTable($lendRecords);
    }

    private function makeDataTable($lendRecords)
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
            ->addColumn('account_branch',function($lendRecord){
                return $lendRecord->account->bank_branch;
            })
            ->make(true);
    }

    public function update(Request $request)
    {
        $messages = [
            'required' => ':attribute 不得为空.',
            'exists'   => '此订单不存在，请刷新页面后重试.',
        ];

        $validator = Validator::make( $request->toArray(), [
            'id' => 'required|exists:authcodes,id',
            'operation' => 'required|in:0,1',
        ],$messages);

        if ($validator->fails())
        {
            $messages ="";

            $errors = $validator->errors();
            foreach ($errors->all('<li>:message</li>') as $message) {
                $messages .= $message;
            }

            return Response::json(array(
                'Result' => 'error',
                'Message'=> $messages
            ));
        }

        $authCode = Authcode::find($request->id);

        //訂單下申請狀態不能作管理
        if($authCode->pay_state != 4){
            return Response::json(array(
                'Result' => 'error',
                'Message'=> '此单非申请下发状态，请重新整理后再次尝试'
            ));
        }

        $user = Sentinel::getUser();

        if($request->operation){
            $authCode->update(['pay_state' => AuthCodes::accept_state, 'pay_summary' => AuthCodes::accept_summary]);

            activity($user->email)
                ->causedBy($user)
                ->log('准許下发了订单'.$authCode->trade_seq);
        }
        else{
            $authCode->update(['pay_state' => AuthCodes::deny_state, 'pay_summary' => AuthCodes::deny_summary]);

            activity($user->email)
                ->causedBy($user)
                ->log('拒絕下發了订单'.$authCode->trade_seq);
        }

        return Response::json(array(
            'Result' => 'OK'
        ));
    }
}
