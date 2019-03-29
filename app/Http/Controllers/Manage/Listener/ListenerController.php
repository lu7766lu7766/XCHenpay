<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 03:08
 */

namespace App\Http\Controllers\Manage\Listener;

use App\Http\Controllers\Controller;
use App\Http\Requests\Listener\OrderOfBankCardRequest;
use App\Service\ListenerService;

class ListenerController extends Controller
{
    /**
     * @param OrderOfBankCardRequest $request
     * @return \App\Models\Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function order(OrderOfBankCardRequest $request)
    {
        return ListenerService::getInstance()->orderOfBankCard($request);
    }
}
