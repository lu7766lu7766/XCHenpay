<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/30
 * Time: 下午 01:50
 */

namespace App\Service;

use App\Constants\ErrorCode\Article\OOO5CashierPersonalErrorCodes;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Requests\CashierPersonal\PersonalAccountIndexRequest;
use App\Http\Requests\CashierPersonal\PersonalAccountInfoRequest;
use App\Http\Requests\CashierPersonal\PersonalAccountStoreRequest;
use App\Http\Requests\CashierPersonal\PersonalAccountTotalRequest;
use App\Http\Requests\CashierPersonal\PersonalAccountUpdateRequest;
use App\Models\BankCardAccount;
use App\Models\Payment;
use App\Repositories\PaymentRepo;
use App\Repositories\PersonalBankCardAccountRepo;
use App\Traits\Singleton;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use XC\Independent\Kit\Support\Scalar\ArrayMaster;

/**
 * Class PersonalAccountService
 * @package App\Service
 */
class PersonalBankCardAccountService
{
    use Singleton;
    /** @var User $user */
    private $user;

    /**
     * @param User $user
     */
    public function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param PersonalAccountIndexRequest $request
     * @return BankCardAccount[]|Collection
     */
    public function list(PersonalAccountIndexRequest $request)
    {
        return app(PersonalBankCardAccountRepo::class)->list(
            $this->user->getKey(),
            $request->getStatus(),
            $request->getSearch(),
            $request->getPage(),
            $request->getPerpage()
        );
    }

    /**
     * @param PersonalAccountTotalRequest $request
     * @return int
     */
    public function total(PersonalAccountTotalRequest $request)
    {
        return app(PersonalBankCardAccountRepo::class)->total(
            $this->user->getKey(),
            $request->getStatus(),
            $request->getSearch()
        );
    }

    /**
     * @return Payment[]|\Illuminate\Support\Collection
     */
    public function channel()
    {
        return app(PaymentRepo::class)->getUserActivePayment($this->user->getKey());
    }

    /**
     *
     *
     * @param PersonalAccountStoreRequest $request
     * @return BankCardAccount|null
     * @throws ApiErrorScalarCodeException
     */
    public function create(PersonalAccountStoreRequest $request)
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
                    OOO5CashierPersonalErrorCodes::GET_BANK_MARK_ERROR
                );
            }
        }
        $result = app(PersonalBankCardAccountRepo::class)->create(
            $this->user->getKey(),
            $data,
            $request->getChannel(),
            $detail
        );

        return $result;
    }

    /**
     * @param PersonalAccountUpdateRequest $request
     * @return BankCardAccount|null
     */
    public function update(PersonalAccountUpdateRequest $request)
    {
        $item = app(PersonalBankCardAccountRepo::class)->info($this->user->getKey(), $request->getId());
        if (!is_null($item)) {
            /** @var Payment|null $payment */
            $payment = $item->payment->first();
            $detail = null;
            if (!is_null($payment)) {
                $detail = $payment->payment_information->payment_detail;
                $detail['card_id'] = $request->getCardId();
            }
            $item = app(PersonalBankCardAccountRepo::class)->update(
                $item,
                [
                    'status'          => $request->getStatus(),
                    'minimum_amount'  => $request->getMinimumAmount(),
                    'maximum_amount'  => $request->getMaximumAmount(),
                    'statistics_type' => $request->getStatisticsType(),
                    'total_amount'    => $request->getTotalAmount(),
                ],
                $detail
            );
        }

        return $item;
    }

    /**
     * @param PersonalAccountInfoRequest $request
     * @return BankCardAccount|null
     */
    public function info(PersonalAccountInfoRequest $request)
    {
        return app(PersonalBankCardAccountRepo::class)->info(
            $this->user->getKey(),
            $request->getId()
        );
    }
}
