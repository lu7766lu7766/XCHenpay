<?php

namespace App\Http\Controllers\User;

use App\Constants\Account\AccountStatusConstants;
use App\Constants\Common\VerifyType;
use App\Http\Controllers\Controller;
use App\Http\Requests\BindBankCard\BindBankCardIndexRequest;
use App\Http\Requests\BindBankCard\BindBankCardInfoRequest;
use App\Http\Requests\BindBankCard\BindBankCardTotalRequest;
use App\Http\Requests\BindBankCardCreateRequest;
use App\Models\Account;
use App\Service\BindBankCardService;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class BindBankCardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexView()
    {
        return view('admin.users.addAccount');
    }

    /**
     * @param BindBankCardIndexRequest $request
     * @return Account[]|Collection
     */
    public function index(BindBankCardIndexRequest $request)
    {
        return BindBankCardService::getInstance(\Sentinel::getUser())->list($request);
    }

    /**
     * @param BindBankCardTotalRequest $request
     * @return int
     */
    public function total(BindBankCardTotalRequest $request)
    {
        return BindBankCardService::getInstance(\Sentinel::getUser())->total($request);
    }

    /**
     * @param BindBankCardInfoRequest $request
     * @return User|null
     */
    public function info(BindBankCardInfoRequest $request)
    {
        return BindBankCardService::getInstance(\Sentinel::getUser())->info($request);
    }

    /**
     * @param BindBankCardCreateRequest $request
     * @return array
     * @throws \App\Exceptions\ApiErrorCodeException
     * @throws \Throwable
     */
    public function create(BindBankCardCreateRequest $request)
    {
        return ['data' => BindBankCardService::getInstance(\Sentinel::getUser())->create($request)];
    }

    /**
     * @return array
     */
    public function status()
    {
        return AccountStatusConstants::enum();
    }

    /**
     * 發送驗證碼
     * @return array
     * @throws \App\Exceptions\ApiErrorCodeException
     */
    public function sendVerifyCode()
    {
        return BindBankCardService::getInstance(\Sentinel::getUser())->sendVerifyCode(VerifyType::ACCOUNT);
    }
}
