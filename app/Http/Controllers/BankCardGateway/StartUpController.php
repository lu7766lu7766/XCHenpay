<?php

namespace App\Http\Controllers\BankCardGateway;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankCardGateway\GatewayRequest;
use App\Service\StartUpService;

class StartUpController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function selectView()
    {
        return view('gateway.select');
    }

    /**
     * @param GatewayRequest $request
     * @return string
     */
    public function taoBo(GatewayRequest $request)
    {
        return StartUpService::getInstance()->taoBo($request);
    }

    /**
     * @param GatewayRequest $request
     * @return string
     */
    public function aliPay(GatewayRequest $request)
    {
        return StartUpService::getInstance()->aliPay($request);
    }
}
