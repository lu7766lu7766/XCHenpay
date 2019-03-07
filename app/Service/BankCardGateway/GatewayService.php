<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/2/12
 * Time: 下午 02:19
 */

namespace App\Service\BankCardGateway;

use App\Constants\ErrorCode\Article\OOO6BankCardGatewayErrorCodes;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Requests\BankCardGateway\GatewayRequest;
use App\Models\BankCardAccount;
use App\Repositories\AuthCodes;
use App\Traits\Singleton;

class GatewayService
{
    use Singleton;

    /**
     * @param GatewayRequest $request
     * @return array
     * @throws ApiErrorScalarCodeException
     */
    public function gateway(GatewayRequest $request)
    {
        $orderInfo = app(AuthCodes::class)->getPayGateway($request->getTradeSeq());
        /** @var BankCardAccount $bankCard */
        if (is_null($orderInfo) && !isset($orderInfo->bankCardAccount)) {
            throw new ApiErrorScalarCodeException(
                '订单不存在或已经过期，请重新发起支付',
                OOO6BankCardGatewayErrorCodes::ORDER_NOT_EXIST_OR_EXPIRED
            );
        }
        $bankCard = $orderInfo->bankCardAccount->first();
        $result = [
            'order_number' => $orderInfo->trade_service_id,
            'amount'       => $orderInfo->amount,
            'expired_time' => $orderInfo->created_at->addMinute(5)->toDateTimeString(),
            'qrcode_url'   => $bankCard->gatewayUri->uri
        ];

        return $result;
    }

    /**
     * @param GatewayRequest $request
     * @return null|string
     */
    public function paymentGate(GatewayRequest $request)
    {
        $result = null;
        $orderInfo = app(AuthCodes::class)->findPaymentWindow($request->getTradeSeq());
        if (!is_null($orderInfo) && isset($orderInfo->paymentWindow)) {
            $result = $orderInfo->paymentWindow->entrance;
        }

        return $result;
    }
}
