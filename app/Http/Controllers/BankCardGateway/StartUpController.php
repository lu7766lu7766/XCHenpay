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
        return view('gateway.to_bank_card');
    }

    /**
     * @param GatewayRequest $request
     * @return mixed
     */
    public function taoBo(GatewayRequest $request)
    {
        $url = StartUpService::getInstance()->taoBo($request);
        return response('', 200)->header('Location', $url);
    }
}
