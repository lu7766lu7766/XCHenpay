<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/27
 * Time: 下午 04:47
 */

namespace App\Service;

use App\Constants\Order\OrderStatusConstants;
use App\Http\Requests\AuthCodeOrderNotifyRequest;
use App\Repositories\AuthCodes;
use App\Traits\Singleton;

class OrderService
{
    use Singleton;

    /**
     * @param AuthCodeOrderNotifyRequest $request
     * @return bool
     */
    public function callNotify(AuthCodeOrderNotifyRequest $request)
    {
        $result = false;
        $order = app(AuthCodes::class)->find($request->getId());
        if (!is_null($order) && ($order->pay_state == OrderStatusConstants::SUCCESS_CODE) ||
            ($order->pay_state == OrderStatusConstants::ALL_DONE_CODE)) {
            $result = app(OrderNotifyService::class)->notify($order);
        }

        return $result;
    }
}
