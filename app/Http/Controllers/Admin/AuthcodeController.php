<?php

namespace App\Http\Controllers\Admin;

use Sentinel;
use App\User;
use App\Authcode;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class AuthcodeController extends Controller
{
    public function index(){

        $user = Sentinel::getUser();

        $switchPromission = $user->hasAccess('users.dataSwitch');

        if($switchPromission)
            $companies = User::all()->where('company_service_id', '<>', null);

        return view('admin.trade.logQuery', compact('companies', 'switchPromission'));
    }

    public function data()
    {
        $dateFilter = explode(' - ',request()->dateFilter);
        $startDate = $dateFilter[0];
        $endDate = $dateFilter[1];

//        dd($startDate . ' ' . $endDate);

        $user = Sentinel::getUser();
        $company = User::find(request()->company);

        $getData = array(
            'pay_summary',
            'trade_seq',
            'company_service_id',
//            'company_name',
            'amount',
            'currency_id',
            'payment_type',
//            'fee',
            'created_at',
            'pay_start_time',
            'pay_end_time');

        if($user->hasAccess('users.dataSwitch')){
            if(isset(request()->company)){
                $authCodes = Authcode::whereBetween('created_at',[$startDate, $endDate])
                    ->where('company_service_id', '=', $company->company_service_id)->get($getData);
            }else
                $authCodes = Authcode::whereBetween('created_at',[$startDate, $endDate])
                    ->get($getData)
                    ->all();
        }else
            $authCodes = Authcode::whereBetween('created_at',[$startDate, $endDate])
                ->where('company_service_id', '=', $user->company_service_id)
                ->get($getData);


        //dd($authCodes[1]->company);
//
//        if($userRoles != 3)     //admin
//            $authCodes = Authcode::get($getData)->all();
//        else                    //other roles
//            $authCodes = Authcode::where('company_service_id', '=', Sentinel::getUser()->company_service_id)
//                ->get($getData);

//        dd($authCodes);

        return DataTables::of($authCodes)
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
            ->make(true);
    }
}
