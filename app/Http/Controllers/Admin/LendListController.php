<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Common\VerifyType;
use App\Constants\Lend\LendStatusConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\LendList\LendListApplyRequest;
use App\Http\Requests\LendList\LendListIndexRequest;
use App\Http\Requests\LendListInfoRequest;
use App\Http\Requests\LendListTotalRequest;
use App\Service\LendListService;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LendListController extends Controller
{
    /**
     * @return View
     */
    public function indexView()
    {
        return view('admin.lend_list.index');
    }

    /**
     * @return UserInterface|null
     */
    public function userInfo()
    {
        return \Sentinel::getUser();
    }

    /**
     * @return array
     */
    public function amountInfo()
    {
        return LendListService::getInstance()->amountInfo();
    }

    /**
     * @param LendListIndexRequest $request
     * @return array
     */
    public function index(LendListIndexRequest $request)
    {
        return LendListService::getInstance()->index($request);
    }

    /**
     * @return array
     */
    public function lendStatus()
    {
        return LendStatusConstants::enum();
    }

    /**
     * @param LendListApplyRequest $request
     * @return array
     * @throws \Exception
     */
    public function apply(LendListApplyRequest $request)
    {
        return ['data' => LendListService::getInstance()->apply($request)];
    }

    /**
     * @param LendListTotalRequest $request
     * @return array
     */
    public function total(LendListTotalRequest $request)
    {
        return LendListService::getInstance()->total($request);
    }

    /**
     * @param $id
     * @return \App\Models\LendRecord|null
     * @throws ValidationException
     */
    public function info($id)
    {
        return LendListService::getInstance()->info(LendListInfoRequest::getHandle(['id' => $id]));
    }

    /**
     * @return array
     */
    public function backAccountInfo()
    {
        return LendListService::getInstance()->backAccountInfo();
    }

    /**
     * 發送驗證碼
     * @return array
     * @throws \App\Exceptions\ApiErrorCodeException
     */
    public function sendVerifyCode()
    {
        return LendListService::getInstance()->sendVerifyCode(VerifyType::LEND_LIST);
    }
}
