<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Common\VerifyType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AddAccountRequest;
use App\Http\Requests\Account\DeleteAccountRequest;
use App\Models\Account;
use App\Service\AccountService;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    /**
     * 行卡列表(view)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.users.accountList');
    }

    /**
     * 取得商戶列表
     * @return Collection|User[]
     */
    public function getCompany()
    {
        return AccountService::getInstance()->companyInfo();
    }

    /**
     * 行卡列表
     * @return Account[]|Collection
     * @throws ValidationException
     */
    public function accountData()
    {
        return AccountService::getInstance()->accountData(request()->all());
    }

    /**
     * 行卡列表總數
     * @return int
     * @throws ValidationException
     */
    public function total()
    {
        return AccountService::getInstance()->total(request()->all());
    }

    /**
     * 銀卡刪除
     * @return Account|Model|null
     * @throws \Throwable
     */
    public function deleteAccount()
    {
        return AccountService::getInstance()->delete(DeleteAccountRequest::getHandle(request()->all()));
    }

    /**
     * 行卡綁定(view)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createAccount()
    {
        return view('admin.users.addAccount');
    }

    /**
     * 發送驗證碼
     * @return array
     * @throws \App\Exceptions\ApiErrorCodeException
     */
    public function sendVerifyCode()
    {
        return AccountService::getInstance()->sendVerifyCode(VerifyType::ACCOUNT);
    }

    /**
     * 銀行卡綁定
     * @return array
     * @throws \Throwable
     */
    public function addAccount()
    {
        return AccountService::getInstance()->addAccount(AddAccountRequest::getHandle(request()->all()));
    }

    /**
     * 綁定銀行卡列表
     * @return Account[]|Collection
     * @throws ValidationException
     */
    public function accountList()
    {
        return AccountService::getInstance()->accountList(request()->all());
    }

    /**
     * 綁定銀行卡列表總數
     * @return int
     * @throws ValidationException
     */
    public function listTotal()
    {
        return AccountService::getInstance()->listTotal(request()->all());
    }

    /**
     * 綁定行卡刪除
     * @return Account|Model|null
     * @throws ValidationException
     * @throws \Throwable
     */
    public function deleteAccountData()
    {
        return AccountService::getInstance()->deleteData(DeleteAccountRequest::getHandle(request()->all()));
    }
}
