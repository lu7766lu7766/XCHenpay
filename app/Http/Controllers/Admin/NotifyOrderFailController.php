<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderFail\NotifyOrderFailIndexRequest;
use App\Http\Requests\OrderFail\NotifyOrderFailTotalRequest;
use App\Service\NotifyOrderFailService;

class NotifyOrderFailController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexView()
    {
        return view('admin.log.notifyOrderFail');
    }

    /**
     * @param NotifyOrderFailIndexRequest $request
     * @return array
     */
    public function index(NotifyOrderFailIndexRequest $request)
    {
        return ['data' => NotifyOrderFailService::getInstance()->list($request)];
    }

    /**
     * @param NotifyOrderFailTotalRequest $request
     * @return array
     */
    public function total(NotifyOrderFailTotalRequest $request)
    {
        return ['data' => NotifyOrderFailService::getInstance()->total($request)];
    }
}
