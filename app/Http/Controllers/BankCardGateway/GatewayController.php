<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/2/12
 * Time: 下午 02:19
 */

namespace App\Http\Controllers\BankCardGateway;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankCardGateway\GatewayRequest;
use App\Service\BankCardGateway\GatewayService;

class GatewayController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexView()
    {
        return view('gateway.alipay');
    }

    /**
     * @param GatewayRequest $request
     * @return array
     * @throws \App\Exceptions\ApiErrorScalarCodeException
     */
    public function index(GatewayRequest $request)
    {
        return GatewayService::getInstance()->gateway($request);
    }
}
