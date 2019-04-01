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

/**
 * @todo class name 範圍很大,如果要用此名稱 需要再namespace上面增加更多prefix , e.g. Manage\Order
 * Class ListenerRepo
 * @package App\Repositories
 */
class ListenerRepo
{
    /**
     * @param int $id
     * @return Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function getOrderOfBankCard(int $id)
    {
        // @todo 時間的參數移至params. 讓使用者丟進她想要的時間.
        $time = Carbon::today();
        // @todo 應該要有狀態條件(pay_state),如果有也請放置到params.
        // @todo 應該要有通道條件(payment_type),例如條件都是轉銀行卡的通道,並運用關聯查詢代入該條件.
        return Authcode::query()
            ->whereHas('bankCardAccount', function (Builder $builder) use ($id) {
                $builder->where('bank_card_account.id', $id);
            })->whereBetween('created_at', [
                $time->startOfDay()->toDateTimeString(),
                $time->endOfDay()->toDateTimeString()
            ])->get();
    }
}
