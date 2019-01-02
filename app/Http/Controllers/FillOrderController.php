<?php

namespace App\Http\Controllers;

use App\Constants\Order\OrderStatusConstants;
use App\Http\Requests\FillOrderEditRequest;
use App\Http\Requests\FillOrderInfoRequest;
use App\Http\Requests\FillOrderListRequest;
use App\Service\FillOrderService;

class FillOrderController extends Controller
{
    public function view()
    {
        return view('admin.search.replenishment');
    }

    /**
     * @param FillOrderListRequest $request
     * @return array
     */
    public function index(FillOrderListRequest $request)
    {
        return FillOrderService::getInstance()->getList($request);
    }

    /**
     * @param FillOrderListRequest $request
     * @return int
     */
    public function total(FillOrderListRequest $request)
    {
        return FillOrderService::getInstance()->total($request);
    }

    /**
     * @param $id
     * @return \App\Models\Authcode|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function info($id)
    {
        $handle = FillOrderInfoRequest::getHandle(compact('id'));

        return FillOrderService::getInstance()->getOrder($handle);
    }

    /**
     * @param FillOrderEditRequest $request
     * @return \App\Models\Authcode|null
     * @throws \Throwable
     */
    public function edit(FillOrderEditRequest $request)
    {
        return FillOrderService::getInstance()->edit($request, config('app.key'));
    }

    /**
     * @return array
     */
    public function options()
    {
        $service = FillOrderService::getInstance();

        return [
            'merchants'  => $service->merchants(),
            'pay_states' => OrderStatusConstants::fillOrderEnum(),
            'payment'    => $service->effectivePayment(),
        ];
    }
}
