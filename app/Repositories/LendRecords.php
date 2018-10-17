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
            ->whereHas('account', function ($builder) use ($userId) {
                $builder->where('accounts.user_id', $userId);
            })
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

    /**
     * @param $start
     * @param $end
     * @param int|null $userId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getTotal($start, $end, int $userId = null)
    {
        $startDate = $start . ' 00:00:00';
        $endDate = $end . ' 23:59:59';
        $query = LendRecord::query()->whereBetween('created_at', [$startDate, $endDate]);
        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }
        $query->select(\DB::raw('sum(amount-fee) as total'));
        $result = $query->first();

        return $result;
    }
}
