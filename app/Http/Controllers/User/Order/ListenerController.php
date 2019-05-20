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
use App\Service\User\Order\ListenerService;

class ListenerController extends Controller
{
    /**
     * @param BankCardOrderRequest $request
     * @return \App\Models\Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function order(BankCardOrderRequest $request)
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
}
