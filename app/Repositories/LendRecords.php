<?php

namespace App\Repositories;


use App\LendRecord;

class LendRecords
{
    const FEE = 0.0002;

    const APPLY_STATE = 0;
    const ACCEPT_STATE = 1;
    const DENY_STATE = 2;

    const APPLY_SUMMARY = '下发中';
    const ACCEPT_SUMMARY = '完成下发';
    const DENY_SUMMARY = '拒绝下发';

    public function getAllRecords($start, $end)
    {
        $startDate = $start . ' 00:00:00';
        $endDate = $end . ' 23:59:59';

        return $records = LendRecord::whereBetween('created_at', [$startDate, $endDate])
            ->with('account')
            ->with('user')
            ->get([
                'id',
                'record_seq',
                'amount',
                'fee',
                'lend_summary',
                'user_id',
                'account_id',
                'created_at',
                'lend_state'
            ]);
    }

    public function getUserRecords($userId, $start, $end)
    {
        $startDate = $start . ' 00:00:00';
        $endDate = $end . ' 23:59:59';

        return $lendRecords = LendRecord::where('user_id', '=', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('account')
            ->with('user')
            ->get([
                'id',
                'record_seq',
                'amount',
                'fee',
                'lend_summary',
                'user_id',
                'account_id',
                'created_at',
                'lend_state'
            ]);
    }
}