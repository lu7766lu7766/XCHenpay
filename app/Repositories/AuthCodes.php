<?php

namespace App\Repositories;

use App\Authcode;
use App\User;
use Yajra\DataTables\DataTables;

class AuthCodes
{
    const allDone_state = 3;

    const lended_state = 5;
    const accept_state = 6;
    const deny_state = 7;

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
        'fee',
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
            ->make(true);
    }

    public function getMoneyRecord(User $user){
        $authCodes = $user->tradeLogs()->where('pay_state', '=', $this::allDone_state)->get();
        $lendRecords = $user->lendRecords;// == $user->accounts()->with('lendRecords')->get()->pluck('lendRecords');
        $data = array();

        if($authCodes == null)
            return $data['Result'] = 'error';

        $totalLended = 0;
        $totalMoney = 0;
        $totalFee = 0;

        foreach($lendRecords as $lendRecord)
            $totalLended += $lendRecord->amount;

        foreach($authCodes as $authCode)
        {
            $totalMoney += $authCode->amount;
            $totalFee += $authCode->fee;
        }

        $data += ['totalMoney' => number_format($totalMoney,3,".",",")];
        $data += ['totalFee' => number_format($totalFee,3,".",",")];
        $data += ['totalLended' => number_format($totalLended,3,".",",")];
        $data += ['totalIncome' => number_format($totalMoney-$totalFee-$totalLended,3,".",",")];

        return $data;
    }
}