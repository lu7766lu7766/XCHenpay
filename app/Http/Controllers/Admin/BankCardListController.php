<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Account\AccountStatusConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountInfoRequest;
use App\Http\Requests\Account\AccountUpdateRequest;
use App\Http\Requests\Account\DeleteAccountRequest;
use App\Models\Account;
use App\Service\BankCardListService;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class BankCardListController extends Controller
{
    /**
     * 行卡列表(view)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('admin.users.accountList');
    }

    /**
     * 取得商戶列表
     * @return User[]|Collection
     */
    public function getCompany()
    {
        return BankCardListService::getInstance()->companyInfo();
    }

    /**
     * @return array
     */
    public function status()
    {
        return AccountStatusConstants::enum();
    }

    /**
     * 行卡列表
     * @return Account[]|Collection
     * @throws ValidationException
     */
    public function index()
    {
        return BankCardListService::getInstance()->accountData(request()->all());
    }

    /**
     * 行卡列表總數
     * @return int
     * @throws ValidationException
     */
    public function total()
    {
        return BankCardListService::getInstance()->total(request()->all());
    }

    /**
     * @return array
     * @throws ValidationException
     */
    public function delete()
    {
        return [
            'data' => BankCardListService::getInstance()->delete(
                DeleteAccountRequest::getHandle(request()->all())
            )
        ];
    }

    /**
     * 更新
     * @param AccountUpdateRequest $request
     * @return array
     */
    public function update(AccountUpdateRequest $request)
    {
        return BankCardListService::getInstance()->update($request);
    }

    /**
     * @param $id
     * @return Account|null
     * @throws ValidationException
     */
    public function info($id)
    {
        return BankCardListService::getInstance()->info(AccountInfoRequest::getHandle(['id' => $id]));
    }
}
