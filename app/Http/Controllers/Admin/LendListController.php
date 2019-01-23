<?php

namespace App\Http\Controllers\Admin;

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
        return LendListService::getInstance(\Sentinel::getUser())->amountInfo();
    }

    /**
     * @param LendListIndexRequest $request
     * @return array
     */
    public function index(LendListIndexRequest $request)
    {
        return LendListService::getInstance(\Sentinel::getUser())->index($request);
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
        return LendListService::getInstance(\Sentinel::getUser())->apply($request);
    }

    /**
     * @param LendListTotalRequest $request
     * @return array
     */
    public function total(LendListTotalRequest $request)
    {
        return LendListService::getInstance(\Sentinel::getUser())->total($request);
    }

    /**
     * @param $id
     * @return \App\Models\LendRecord|null
     * @throws ValidationException
     */
    public function info($id)
    {
        return LendListService::getInstance(\Sentinel::getUser())->info(LendListInfoRequest::getHandle(['id' => $id]));
    }

    /**
     * @return array
     */
    public function bankCardInfo()
    {
        return LendListService::getInstance(\Sentinel::getUser())->bankCardInfo();
    }
}
