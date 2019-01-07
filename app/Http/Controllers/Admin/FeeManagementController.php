<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeManagement\FeeManagementIndexRequest;
use App\Http\Requests\FeeManagement\FeeManagementInfoRequest;
use App\Http\Requests\FeeManagement\FeeManagementStoreRequest;
use App\Service\FeeManagementService;
use Illuminate\Contracts\View\Factory;

class FeeManagementController extends Controller
{
    /**
     * @return Factory
     */
    public function indexView()
    {
        return view('admin.fee.manage');
    }

    /**
     * @param FeeManagementIndexRequest $request
     * @return array
     */
    public function index(FeeManagementIndexRequest $request)
    {
        return ['data' => FeeManagementService::getInstance()->list($request)];
    }

    /**
     * @return array
     */
    public function merchantList()
    {
        return ['data' => FeeManagementService::getInstance()->merchantList()];
    }

    /**
     * @param FeeManagementInfoRequest $request
     * @return array
     */
    public function info(FeeManagementInfoRequest $request)
    {
        return ['data' => FeeManagementService::getInstance()->info($request)];
    }

    /**
     * @param FeeManagementStoreRequest $request
     * @return array
     */
    public function edit(FeeManagementStoreRequest $request)
    {
        return ['data' => FeeManagementService::getInstance()->createOrUpdateByFee($request)];
    }
}
