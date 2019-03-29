<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 03:14
 */

namespace App\Repositories;

use App\Models\Authcode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ListenerRepo
{
    /**
     * @param int $id
     * @return Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function getOrderOfBankCard(int $id)
    {
        $time = Carbon::today();

        return Authcode::query()
            ->whereHas('bankCardAccount', function (Builder $builder) use ($id) {
                $builder->where('bank_card_account.id', $id);
            })->whereBetween('created_at', [
                $time->startOfDay()->toDateTimeString(),
                $time->endOfDay()->toDateTimeString()
            ])->get();
    }
}
