<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 03:10
 */

namespace App\Service;

use App\Http\Requests\Listener\OrderOfBankCardRequest;
use App\Repositories\ListenerRepo;
use App\Traits\Singleton;

/**
 * @todo class name 範圍很大,如果要用此名稱 需要再namespace上面增加更多prefix , e.g. Manage\Order
 * Class ListenerService
 * @package App\Service
 */
class ListenerService
{
    use Singleton;

    /**
     * @param OrderOfBankCardRequest $request
     * @return \App\Models\Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function orderOfBankCard(OrderOfBankCardRequest $request)
    {
        return app(ListenerRepo::class)->getOrderOfBankCard($request->getId());
    }
}
