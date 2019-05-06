<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 03:14
 */

namespace App\Repositories\Manage\Order;

use App\Constants\Order\OrderStatusConstants;
use App\Models\Authcode;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ListenerRepo
 * @package App\Repositories
 */
class ListenerRepo
{
    /**
     * @param int $id
     * @param string $start
     * @param string $end
     * @param int|null $payState
     * @return Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function getOrderOfBankCard(int $id, string $start, string $end, int $payState = null)
    {
        $query = Authcode::query()
            ->whereHas('bankCardAccount', function (Builder $builder) use ($id) {
                $builder->where('bank_card_account.id', $id);
            })->whereBetween('created_at', [$start, $end]);
        if (!is_null($payState)) {
            $query->where('pay_state', $payState);
        }

        return $query->orderBy('id', 'DESC')->get();
    }

    /**
     * @param string $bankCardNo
     * @param float $amount
     * @param string $start
     * @param string $end
     * @return Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function getOrderByCardNoAmountDate(string $bankCardNo, float $amount, string $start, string $end)
    {
        return Authcode::query()
            ->whereIn('pay_state', [OrderStatusConstants::ALL_DONE_CODE, OrderStatusConstants::SUCCESS_CODE])
            ->where(\DB::raw('amount - rand_fee'), $amount)
            ->whereHas('bankCardAccount', function (Builder $builder) use ($bankCardNo) {
                $builder->where('bank_card_account.card_no', $bankCardNo);
            })->whereBetween('created_at', [$start, $end])->get();
    }
}
