<?php

namespace App\Http\Controllers\Manage\Cashier;

use App\Constants\BankCardPayment\BankCardPaymentStatusConstants;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashierCompany\CompanyAccountIndexRequest;
use App\Http\Requests\CashierCompany\CompanyAccountInfoRequest;
use App\Http\Requests\CashierCompany\CompanyAccountStoreRequest;
use App\Http\Requests\CashierCompany\CompanyAccountTotalRequest;
use App\Http\Requests\CashierCompany\CompanyAccountUpdateRequest;
use App\Models\BankCardAccount;
use App\Models\Payment;
use App\Service\CompanyAccountService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class CompanyAccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexView()
    {
        return view("admin.cashier.companyAccount");
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
        return CompanyAccountService::getInstance()->channel();
    }

    /**
     * @param CompanyAccountIndexRequest $request
     * @return BankCardAccount[]|Collection
     */
    public function index(CompanyAccountIndexRequest $request)
    {
        return CompanyAccountService::getInstance()->list($request);
    }

    /**
     * @param CompanyAccountTotalRequest $request
     * @return int
     */
    public function total(CompanyAccountTotalRequest $request)
    {
        return CompanyAccountService::getInstance()->total($request);
    }

    /**
     * @param $id
     * @return BankCardAccount|null
     * @throws ValidationException
     */
    public function info($id)
    {
        return CompanyAccountService::getInstance()->info(CompanyAccountInfoRequest::getHandle(['id' => $id]));
    }

    /**
     * @param CompanyAccountStoreRequest $request
     * @return BankCardAccount|null
     * @throws ApiErrorScalarCodeException
     */
    public function create(CompanyAccountStoreRequest $request)
    {
        return CompanyAccountService::getInstance()->create($request);
    }

    /**
     * @param CompanyAccountUpdateRequest $request
     * @return BankCardAccount|null
     */
    public function update(CompanyAccountUpdateRequest $request)
    {
        return CompanyAccountService::getInstance()->update($request);
    }
}
