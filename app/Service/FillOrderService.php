<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2018/12/26
 * Time: 下午 04:18
 */

namespace App\Service;

use App\Constants\ErrorCode\Article\OOO1FillOrderErrorCodes;
use App\Constants\Order\OrderStatusConstants;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Requests\FillOrderEditRequest;
use App\Http\Requests\FillOrderInfoRequest;
use App\Http\Requests\FillOrderListRequest;
use App\Repositories\FillOrderRepo;
use App\User;
use XC\Independent\Kit\Support\Traits\Pattern\Singleton;

class FillOrderService
{
    use Singleton;
    /**
     * @var FillOrderRepo
     */
    private $repo;

    /**
     * Initialize class.
     */
    protected function init()
    {
        $this->repo = new FillOrderRepo();
    }

    /**
     * @param FillOrderListRequest $request
     * @return \App\Models\Authcode[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getList(FillOrderListRequest $request)
    {
        $result = $this->repo->getList(
            $request->getStart(),
            $request->getEnd(),
            $request->getCompanyServiceId(),
            $request->getPayment(),
            $request->getPayState(),
            $request->getKeyword(),
            $request->getPage(),
            $request->getPerpage()
        );

        return $result->toArray();
    }

    /**
     * @param FillOrderListRequest $request
     * @return int
     */
    public function total(FillOrderListRequest $request)
    {
        $result = $this->repo->total(
            $request->getStart(),
            $request->getEnd(),
            $request->getCompanyServiceId(),
            $request->getPayment(),
            $request->getPayState(),
            $request->getKeyword()
        );

        return $result;
    }

    /**
     * @param FillOrderInfoRequest $request
     * @return \App\Models\Authcode|null
     */
    public function getOrder(FillOrderInfoRequest $request)
    {
        $result = $this->repo->find($request->getId());

        return $result;
    }

    /**
     * @param FillOrderEditRequest $request
     * @param string|null $key user to create trade_seq.
     * @return \App\Models\Authcode|null
     * @throws \Throwable
     */
    public function edit(FillOrderEditRequest $request, string $key)
    {
        $result = null;
        $tradeType = $this->repo->getFillTradeType();
        $currency = $this->repo->getDefaultCurrency();
        if (is_null($tradeType) || is_null($currency)) {
            throw new ApiErrorScalarCodeException('该功能维护中,请稍后片刻再次尝试', OOO1FillOrderErrorCodes::MERCHANT_NOT_EXISTS);
        }
        $merchant = $this->repo->findMerchantByUserId($request->getUserId());
        if (is_null($merchant)) {
            throw new ApiErrorScalarCodeException('指定的商户不存在', OOO1FillOrderErrorCodes::MERCHANT_NOT_EXISTS);
        }
        \DB::transaction(function () use ($key, $currency, $merchant, $request, $tradeType, &$result) {
            $data = [
                'trade_type'       => $tradeType->getKey(),
                'pay_state'        => $request->getPayState(),
                'pay_summary'      => OrderStatusConstants::toSummary($request->getPayState()),
                'trade_service_id' => $request->getTradeServiceId(),
                'amount'           => $request->getAmount(),
                'fee'              => $request->getFee(),
                'payment_type'     => $request->getPayment(),
                'pay_start_time'   => $request->getPayTime(),
                'pay_end_time'     => $request->getPayTime(),
                'currency_id'      => $currency->getKey(),
                'remark'           => $request->getRemark(),
            ];
            $result = $this->repo->saveOrder($key, $request->getId(), $data);
            if (is_null($result)) {
                throw new ApiErrorScalarCodeException('指定的注单不存在', OOO1FillOrderErrorCodes::ORDER_NOT_EXISTS);
            }
            $merchant->tradeLogs()->save($result);
            $result->load(['company', 'payment']);
        });

        return $result;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|User[]
     */
    public function merchants()
    {
        return $this->repo->allMerchant();
    }

    /**
     * @return array
     */
    public function effectivePayment()
    {
        $except = [0];

        return $this->repo->getPayment($except)->toArray();
    }
}
