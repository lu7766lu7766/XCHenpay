<?php

namespace App\Repositories;

use App\Authcode;
use Yajra\DataTables\DataTables;

class AuthCodes
{
    const success_state = 2;

    const lended_state = 4;
    const accept_state = 5;
    const deny_state = 6;

    const lended_summary = '申请下发中';
    const accept_summary = '下发完成';
    const deny_summary = '拒绝下发';

    private $getCol = array(
        'id',
        'pay_summary',
        'trade_seq',
        'company_service_id',
        'amount',
        'currency_id',
        'payment_type',
        'created_at',
        'pay_start_time',
        'pay_end_time');

    public function companyData($company_service_id, $startDate, $endDate)
    {
        return Authcode::where('company_service_id', '=', $company_service_id)
            ->whereBetween('created_at',array($startDate, $endDate))
            ->get($this->getCol);
    }

    public function allData($startDate, $endDate)
    {
        return Authcode::whereBetween('created_at',array($startDate, $endDate))
            ->get($this->getCol);
    }

    public function companyLendData($company_service_id, $startDate, $endDate, $statFilter)
    {
        return Authcode::where('company_service_id', '=', $company_service_id)
            ->whereBetween('created_at',array($startDate, $endDate))
            ->where('pay_state', '=', $statFilter)
            ->get($this->getCol);
    }

    public function allLendData($startDate, $endDate, $statFilter)
    {
        return Authcode::whereBetween('created_at',array($startDate, $endDate))
            ->where('pay_state', '=', $statFilter)
            ->get($this->getCol);
    }

    public function makeSimpleDatatable($authCodes)
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
            ->make(true);
    }
}