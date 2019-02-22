<?php

namespace App\Http\Controllers\Manage\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\CashierManage\AccountManageIndexRequest;
use App\Http\Requests\CashierManage\AccountManageInfoRequest;
use App\Http\Requests\CashierManage\AccountManageTotalRequest;
use App\Models\BankCardAccount;
use App\Service\BankCardAccountManageService;
use App\User;

class AccountManageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexView()
    {
        return view('admin.cashier.accountManage');
    }

    /**
     * @return User[]|\Illuminate\Support\Collection
     */
    public function merchant()
    {
        return BankCardAccountManageService::getInstance()->merchant();
    }

    /**
     * @param AccountManageIndexRequest $request
     * @return BankCardAccount[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(AccountManageIndexRequest $request)
    {
        return BankCardAccountManageService::getInstance()->list($request);
    }

    /**
     * @param AccountManageTotalRequest $request
     * @return int
     */
    public function total(AccountManageTotalRequest $request)
    {
        return BankCardAccountManageService::getInstance()->total($request);
    }

    /**
     * @param AccountManageInfoRequest $request
     * @return BankCardAccount|null
     */
    public function info(AccountManageInfoRequest $request)
    {
        return BankCardAccountManageService::getInstance()->info($request);
    }
}
