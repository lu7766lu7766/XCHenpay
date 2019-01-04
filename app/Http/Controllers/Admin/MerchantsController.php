<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\MerchantsCreateRequest;
use App\Http\Requests\Merchant\MerchantsDeleteRequest;
use App\Http\Requests\Merchant\MerchantsIndexRequest;
use App\Http\Requests\Merchant\MerchantsInfoRequest;
use App\Http\Requests\Merchant\MerchantsTotalRequest;
use App\Http\Requests\Merchant\MerchantsUpdateApplyStatusRequest;
use App\Http\Requests\Merchant\MerchantsUpdateRequest;
use App\Service\MerchantsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Validation\ValidationException;

class MerchantsController extends Controller
{
    /**
     * @return Factory
     */
    public function indexView()
    {
        return view('admin.users.index');
    }

    /**
     * @param MerchantsIndexRequest $request
     * @return array
     */
    public function index(MerchantsIndexRequest $request)
    {
        return ['data' => MerchantsService::getInstance()->list($request)];
    }

    /**
     * @param $id
     * @return array
     * @throws ValidationException
     */
    public function info($id)
    {
        return ['data' => MerchantsService::getInstance()->info(MerchantsInfoRequest::getHandle(['id' => $id]))];
    }

    /**
     * @param MerchantsUpdateRequest $request
     * @return array
     */
    public function update(MerchantsUpdateRequest $request)
    {
        return ['data' => MerchantsService::getInstance()->update($request)];
    }

    /**
     * @param MerchantsDeleteRequest $request
     * @return array
     */
    public function delete(MerchantsDeleteRequest $request)
    {
        return ['data' => MerchantsService::getInstance()->delete($request)];
    }

    /**
     * @param MerchantsTotalRequest $request
     * @return array
     */
    public function total(MerchantsTotalRequest $request)
    {
        return ['data' => MerchantsService::getInstance()->total($request)];
    }

    /**
     * @param MerchantsUpdateApplyStatusRequest $request
     * @return array
     */
    public function updateApplyStatus(MerchantsUpdateApplyStatusRequest $request)
    {
        return ['data' => MerchantsService::getInstance()->updateApplyStatus($request)];
    }

    /**
     * @param MerchantsCreateRequest $request
     * @return array
     */
    public function create(MerchantsCreateRequest $request)
    {
        return ['data' => MerchantsService::getInstance()->create($request)];
    }
}
