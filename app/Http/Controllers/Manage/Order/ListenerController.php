<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 03:08
 */

namespace App\Http\Controllers\Manage\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Listener\BankCardOrderRequest;
use App\Http\Requests\Listener\IsCallBackRequest;
use App\Http\Requests\Listener\OrderRequest;
use App\Models\Authcode;
use App\Service\Manage\Order\ListenerService;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ListenerController
 * @package App\Http\Controllers\Manage\Listener
 */
class ListenerController extends Controller
{
    /**
     * @param BankCardOrderRequest $request
     * @return Authcode|Collection
     */
    public function bankCardOrder(BankCardOrderRequest $request)
    {
        return ListenerService::getInstance()->orderOfBankCard($request);
    }

    /**
     * 是否已經回調
     * @param IsCallBackRequest $request
     * @return array
     */
    public function isCallBack(IsCallBackRequest $request)
    {
        return ['data' => ListenerService::getInstance()->isCallBack($request)];
    }

    /**
     * @param OrderRequest $request
     * @return Authcode[]|Collection
     */
    public function order(OrderRequest $request)
    {
        return ListenerService::getInstance()->findOrders($request);
    }
}
