<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $user = Sentinel::getUser();

        $switchPromission = $user->hasAccess('users.dataSwitch');

        if($switchPromission)
            $companies = User::all()->where('company_service_id', '<>', null);

        // Show the page
        return view('admin.trade.lendApply', compact('companies', 'switchPromission'));
    }

    public function data(AuthCodes $AuthCodes)
    {
        $startDate = request()->startDate . ' 00:00:00';
        $endDate = request()->endDate . ' 23:59:59';

        if(isset(request()->company)){
            $company = User::find(request()->company);

            $authCodes = $AuthCodes->companyLendData($company->company_service_id, $startDate, $endDate, $AuthCodes::success_state);
        }else{
            $authCodes = $AuthCodes->allLendData($startDate, $endDate, $AuthCodes::success_state);
        }

        return $this->makeOpertionDatatable($authCodes);
    }

    public function showApplyDialog(Authcode $authcode)
    {
        $accounts = User::where('company_service_id', '=', $authcode->company_service_id)
            ->first()->accounts->pluck('account');

        return view('admin.trade.selectAccountModel', compact('accounts', 'authcode'));
    }

    public function apply(Request $request)
    {
        $messages = [
            'required' => ':attribute 是必填资讯.',
            'exists'   => '此帐号不存在，请刷新页面后重试.',
            'integer'  => '请输入合法帐号，应由数字构成',
        ];

        $validator = Validator::make( $request->toArray(), [
            'id' => 'required',
            'account' => 'required|exists:accounts,account'
        ], $messages);

        if ($validator->fails())
            return $this->validateErrorResponseInJsonWithLi($validator);

        $authCode = Authcode::find($request->id);

        //只有完成交易可以下發
        if($authCode->pay_state != AuthCodes::success_state){
            $jTableResult = [];
            $jTableResult['Result'] = "error";
            $jTableResult['Message'] = "此订单非处于可下发状态";//"<li>此订单非处于可下发状态<li>";
            return $jTableResult;
        }else{
            $authCode->pay_state = AuthCodes::lended_state;
            $authCode->pay_summary = AuthCodes::lended_summary;
            $authCode->account = $request->account;

            $user = Sentinel::getUser();
            activity($user->email)
                ->causedBy($user)
                ->log('申請了下發订单'.$authCode->trade_seq);
        }

        if($authCode->save() )
        {
            return Response::json(array(
                'Result' => 'OK',
            ));
        }
    }

    private function makeOpertionDatatable($authCodes)
    {
        return DataTables::of($authCodes)
            ->addColumn('short_trade_seq',function($authCode){
                return substr($authCode->trade_seq, 0, 10) . '...';
            })
            ->addColumn('payment_name',function($authCode){
                return $authCode->i6payment->name;
            })
            ->addColumn('currency_name',function($authCode){
                return $authCode->currency->name;
            })
            ->addColumn('company_name',function($authCode){
                return $authCode->company->company_name;
            })
            ->addColumn('payment_fee',function($authCode){
                return $authCode->i6payment->fee;
            })
            ->addColumn('actions',function($authCode){
                $lendLink = '<a href='. route('admin.lendApply.selectAccount', ['authcode' => $authCode->id]) .' data-toggle="modal" data-target="#delete_confirm">
                <i class="livicon" data-name="rocket" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title=' . trans('Trade/LendApply/form.lendApply') . '></i></a>';

                return $lendLink;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
