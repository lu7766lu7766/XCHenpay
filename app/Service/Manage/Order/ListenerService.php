<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 03:10
 */

namespace App\Service\Manage\Order;

use App\Http\Requests\Listener\BankCardOrderRequest;
use App\Repositories\Manage\Order\ListenerRepo;
use App\Traits\Singleton;

/**
 * Class ListenerService
 * @package App\Service
 */
class ListenerService
{
    use Singleton;

    /**
     * @param BankCardOrderRequest $request
     * @return \App\Models\Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function orderOfBankCard(BankCardOrderRequest $request)
    {
        return app(ListenerRepo::class)->getOrderOfBankCard($request->getId(), $request->getPayState());
    }
}
