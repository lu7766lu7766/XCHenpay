<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 03:14
 */

namespace App\Repositories\Manage\Order;

use App\Models\Authcode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ListenerRepo
 * @package App\Repositories
 */
class ListenerRepo
{
    /**
     * @param int $id
     * @param int|null $payState
     * @return Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function getOrderOfBankCard(int $id, int $payState = null)
    {
        $time = Carbon::now();
        $end = $time->startOfMinute()->toDateTimeString();
        $start = $time->subMinute(config('manageorderlistener.search_time'))->startOfMinute()->toDateTimeString();
        $query = Authcode::query()
            ->whereHas('bankCardAccount', function (Builder $builder) use ($id) {
                $builder->where('bank_card_account.id', $id);
            })->whereBetween('created_at', [$start, $end]);
        if (!is_null($payState)) {
            $query->where('pay_state', $payState);
        }

        return $query->orderBy('id', 'DESC')->get();
    }
}
