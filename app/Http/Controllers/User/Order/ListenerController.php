<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/14
 * Time: 下午 06:42
 */

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Listener\BankCardOrderRequest;
use App\Http\Requests\Listener\IsCallBackRequest;
use App\Http\Requests\Listener\OrderRequest;
use App\Models\Authcode;
use App\Service\User\Order\ListenerService;
use Illuminate\Database\Eloquent\Collection;

class ListenerController extends Controller
{
    /**
     * @param BankCardOrderRequest $request
     * @return Authcode|Collection
     */
    public function bankCardOrder(BankCardOrderRequest $request)
    {
        return ListenerService::getInstance(\Sentinel::getUser())->orderOfBankCard($request);
    }

    /**
     * @param IsCallBackRequest $request
     * @return array
     */
    public function isCallBack(IsCallBackRequest $request)
    {
        return ['data' => ListenerService::getInstance(\Sentinel::getUser())->isCallBack($request)];
    }

    /**
     * @param OrderRequest $request
     * @return Authcode[]|Collection
     */
    public function orders(OrderRequest $request)
    {
        return ListenerService::getInstance(\Sentinel::getUser())->orders($request);
    }
}
