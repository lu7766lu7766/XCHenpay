<?php

namespace App\Repositories;


use App\User;

class LendRecords
{
    public function getUserRecords(User $user, $start, $end)
    {
        $startDate = $start . ' 00:00:00';
        $endDate = $end . ' 23:59:59';

        return $lendRecords = $user->LendRecords()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('account')
            ->get();
    }
}