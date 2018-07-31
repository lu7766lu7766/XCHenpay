<?php

namespace App\Repositories;


use App\User;

class LendRecords
{
    const APPLY_STATE = 0;
    const ACCEPT_STATE = 1;
    const DENY_STATE = 2;

    const APPLY_SUMMARY = '下发中';
    const ACCEPT_SUMMARY = '完成下发';
    const DENY_SUMMARY = '拒绝下发';

    public function getUserRecords(User $user, $start, $end)
    {
        $startDate = $start . ' 00:00:00';
        $endDate = $end . ' 23:59:59';

        return $lendRecords = $user->LendRecords()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('account')
            ->get([
                'id',
                'record_seq',
                'amount',
                'fee',
                'lend_summary',
                'account_id',
                'created_at',
                'lend_state'
            ]);
    }
}