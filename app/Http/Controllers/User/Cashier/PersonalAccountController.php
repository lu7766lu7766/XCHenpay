<?php

namespace App\Http\Controllers\User\Cashier;

use App\Constants\BankCardPayment\BankCardPaymentStatusConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashierPersonal\PersonalAccountIndexRequest;
use App\Http\Requests\CashierPersonal\PersonalAccountInfoRequest;
use App\Http\Requests\CashierPersonal\PersonalAccountStoreRequest;
use App\Http\Requests\CashierPersonal\PersonalAccountTotalRequest;
use App\Http\Requests\CashierPersonal\PersonalAccountUpdateRequest;
use App\Models\BankCardAccount;
use App\Models\Payment;
use App\Service\PersonalBankCardAccountService;
use Illuminate\Database\Eloquent\Collection;

class PersonalAccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexView()
    {
        return view('admin.cashier.accountSetting');
    }

    /**
     * @param PersonalAccountIndexRequest $request
     * @return BankCardAccount[]|Collection
     */
    public function index(PersonalAccountIndexRequest $request)
    {
        return PersonalBankCardAccountService::getInstance(\Sentinel::getUser())->list($request);
    }

    /**
     * @param PersonalAccountTotalRequest $request
     * @return int
     */
    public function total(PersonalAccountTotalRequest $request)
    {
        return PersonalBankCardAccountService::getInstance(\Sentinel::getUser())->total($request);
    }

    /**
     * @return array
     */
    public function status()
    {
        return BankCardPaymentStatusConstants::enum();
    }

    /**
     * @return Payment[]|\Illuminate\Support\Collection
     */
    public function channel()
    {
        return PersonalBankCardAccountService::getInstance(\Sentinel::getUser())->channel();
    }

    /**
     * @param PersonalAccountStoreRequest $request
     * @return BankCardAccount|null
     * @throws \App\Exceptions\ApiErrorScalarCodeException
     */
    public function create(PersonalAccountStoreRequest $request)
    {
        return PersonalBankCardAccountService::getInstance(\Sentinel::getUser())->create($request);
    }

    /**
     * @param PersonalAccountUpdateRequest $request
     * @return int
     */
    public function update(PersonalAccountUpdateRequest $request)
    {
        return PersonalBankCardAccountService::getInstance(\Sentinel::getUser())->update($request);
    }

    /**
     * @param $id
     * @return BankCardAccount|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function info($id)
    {
        return PersonalBankCardAccountService::getInstance(\Sentinel::getUser())
            ->info(PersonalAccountInfoRequest::getHandle(['id' => $id]));
    }
}
