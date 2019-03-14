<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/28
 * Time: 下午 03:36
 */

namespace App\Service;

use App\Constants\ErrorCode\Article\OOO4CashierCompanyErrorCodes;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Requests\CashierCompany\CompanyAccountIndexRequest;
use App\Http\Requests\CashierCompany\CompanyAccountInfoRequest;
use App\Http\Requests\CashierCompany\CompanyAccountStoreRequest;
use App\Http\Requests\CashierCompany\CompanyAccountTotalRequest;
use App\Http\Requests\CashierCompany\CompanyAccountUpdateRequest;
use App\Models\BankCardAccount;
use App\Models\Payment;
use App\Repositories\BankCardAccountRepo;
use App\Repositories\PaymentRepo;
use App\Traits\Singleton;
use Illuminate\Database\Eloquent\Collection;
use XC\Independent\Kit\Support\Scalar\ArrayMaster;

class CompanyAccountService
{
    use Singleton;

    /**
     * @param CompanyAccountIndexRequest $request
     * @return BankCardAccount[]|Collection
     */
    public function list(CompanyAccountIndexRequest $request)
    {
        return app(BankCardAccountRepo::class)->companyList(
            $request->getStatus(),
            $request->getSearch(),
            $request->getPage(),
            $request->getPerpage()
        );
    }

    /**
     * @param CompanyAccountTotalRequest $request
     * @return int
     */
    public function total(CompanyAccountTotalRequest $request)
    {
        return app(BankCardAccountRepo::class)->companyTotal(
            $request->getStatus(),
            $request->getSearch()
        );
    }

    /**
     * @param CompanyAccountInfoRequest $request
     * @return BankCardAccount|null
     */
    public function info(CompanyAccountInfoRequest $request)
    {
        return app(BankCardAccountRepo::class)->companyInfo($request->getId());
    }

    /**
     * @param CompanyAccountStoreRequest $request
     * @return BankCardAccount|null
     * @throws ApiErrorScalarCodeException
     */
    public function create(CompanyAccountStoreRequest $request)
    {
        $result = null;
        $data = [
            'user_name'       => $request->getUserName(),
            'card_no'         => $request->getCardNo(),
            'bank_name'       => $request->getBankName(),
            'status'          => $request->getStatus(),
            'minimum_amount'  => $request->getMinimumAmount(),
            'maximum_amount'  => $request->getMaximumAmount(),
            'statistics_type' => $request->getStatisticsType(),
            'total_amount'    => $request->getTotalAmount(),
        ];
        $detail = ['card_id' => $request->getCardId()];
        $service = BankCardDetectorFactory::make($request->getChannel());
        if (!is_null($service)) {
            try {
                $detail = ArrayMaster::arrayMerge($detail, $service->mining($request->getCardNo()));
            } catch (\Exception $e) {
                throw new ApiErrorScalarCodeException(
                    $e->getMessage(),
                    OOO4CashierCompanyErrorCodes::GET_BANK_MARK_ERROR
                );
            }
        }
        $result = app(BankCardAccountRepo::class)->create($data, $request->getChannel(), $detail);

        return $result;
    }

    /**
     * @param CompanyAccountUpdateRequest $request
     * @return BankCardAccount|null
     */
    public function update(CompanyAccountUpdateRequest $request)
    {
        $item = app(BankCardAccountRepo::class)->companyInfo($request->getId());
        if (!is_null($item)) {
            /** @var Payment|null $payment */
            $payment = $item->payment->first();
            $detail = null;
            if (!is_null($payment)) {
                $detail = $payment->payment_information->payment_detail;
                $detail['card_id'] = $request->getCardId();
            }
            $item = app(BankCardAccountRepo::class)->companyUpdate(
                $item,
                [
                    'status'          => $request->getStatus(),
                    'minimum_amount'  => $request->getMinimumAmount(),
                    'maximum_amount'  => $request->getMaximumAmount(),
                    'statistics_type' => $request->getStatisticsType(),
                    'total_amount'    => $request->getTotalAmount()
                ],
                $detail
            );
        }

        return $item;
    }

    /**
     * @return Payment[]|\Illuminate\Support\Collection
     */
    public function channel()
    {
        return app(PaymentRepo::class)->allActive();
    }
}
