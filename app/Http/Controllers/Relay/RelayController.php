<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/11
 * Time: 下午 04:16
 */

namespace App\Http\Controllers\Relay;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankCardGateway\GatewayRequest;
use App\Service\Relay\RelayService;

class RelayController extends Controller
{
    public function view()
    {
        return view('gateway.relay');
    }

    /**
     * @param GatewayRequest $request
     * @return array
     * @throws \App\Exceptions\ApiErrorScalarCodeException
     */
    public function data(GatewayRequest $request)
    {
        return RelayService::getInstance()->relay($request);
    }
}
