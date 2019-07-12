<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 03:10
 */

namespace App\Service\Manage\Order;

use App\Http\Requests\Listener\BankCardOrderRequest;
use App\Http\Requests\Listener\IsCallBackRequest;
use App\Http\Requests\Listener\OrderRequest;
use App\Models\Authcode;
use App\Repositories\Manage\Order\ListenerRepo;
use App\Traits\Singleton;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ListenerService
 * @package App\Service
 */
class ListenerService
{
    use Singleton;

    /**
     * @param BankCardOrderRequest $request
     * @return Authcode|Collection
     */
    public function orderOfBankCard(BankCardOrderRequest $request)
    {
        $time = Carbon::now();
        $end = $time->toDateTimeString();
        $start = $time->subMinute(config('manageorderlistener.search_time'))->startOfMinute()->toDateTimeString();

        return app(ListenerRepo::class)->getOrderOfBankCard(
            $request->getId(),
            $start,
            $end,
            $request->getPayState()
        );
    }

    /**
     * @param IsCallBackRequest $request
     * @return bool
     */
    public function isCallBack(IsCallBackRequest $request)
    {
        $time = new Carbon($request->getDate());
        $end = $time->toDateTimeString();
        $start = $time->subMinute(config('manageorderlistener.compare_time'))->startOfMinute()->toDateTimeString();
        $result = app(ListenerRepo::class)->getOrderByCardNoAmountDate(
            $request->getCardNo(),
            $request->getAmount(),
            $start,
            $end
        )->isNotEmpty();

        return $result;
    }

    /**
     * @param OrderRequest $request
     * @return Authcode[]|Collection
     */
    public function findOrders(OrderRequest $request)
    {
        $time = Carbon::now();
        $end = $time->toDateTimeString();
        $start = $time->subMinute(config('manageorderlistener.search_time'))->startOfMinute()->toDateTimeString();

        return app(ListenerRepo::class)->findOrders(
            $start,
            $end,
            $request->getPaymentType(),
            $request->getPayState()
        );
    }
}
