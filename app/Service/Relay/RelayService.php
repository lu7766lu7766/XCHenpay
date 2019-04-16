<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/11
 * Time: 下午 04:55
 */

namespace App\Service\Relay;

use AliPay\Service\AppTool;
use App\Constants\ErrorCode\Article\OOO1FillOrderErrorCodes;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Requests\BankCardGateway\GatewayRequest;
use App\Repositories\AuthCodes;
use App\Traits\Singleton;

class RelayService
{
    use Singleton;

    /**
     * @param GatewayRequest $request
     * @return array
     * @throws ApiErrorScalarCodeException
     */
    public function relay(GatewayRequest $request)
    {
        $orderInfo = app(AuthCodes::class)->findPaymentWindow($request->getTradeSeq());
        if (is_null($orderInfo)) {
            throw new ApiErrorScalarCodeException('查无订单', OOO1FillOrderErrorCodes::ORDER_NOT_EXISTS);
        }
        if (!is_null($orderInfo->paymentWindow)) {
            $result = [
                'order_number' => $orderInfo->trade_service_id,
                'amount'       => $orderInfo->amountPayable(),
                'expired_time' => $orderInfo->created_at->addMinute(2)->toDateTimeString(),
                'qrcode_url'   => $orderInfo->paymentWindow->entrance,
                'friend_url'   => AppTool::getAddFriendUrl(config('alipay.pid'), config('alipay.app_account_id'))
            ];
        }
        $result['payment_type'] = $orderInfo->payment_type;

        return $result;
    }
}
