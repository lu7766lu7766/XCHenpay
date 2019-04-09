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
use App\Service\Manage\Order\ListenerService;

/**
 * Class OrderController
 * @package App\Http\Controllers\Manage\Listener
 */
class ListenerController extends Controller
{
    /**
     * @param BankCardOrderRequest $request
     * @return \App\Models\Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function order(BankCardOrderRequest $request)
    {
        return ListenerService::getInstance()->orderOfBankCard($request);
    }
}
