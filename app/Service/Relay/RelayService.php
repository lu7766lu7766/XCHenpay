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
use App\Constants\Payment\PaymentConstants;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Requests\BankCardGateway\GatewayRequest;
use App\Models\UserPaymentAccount;
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
            ];
        }
        /** @var UserPaymentAccount $paymentAccount */
        if ($orderInfo->payment_type == PaymentConstants::ALI_PAY_RED_ENVELOPE &&
            ($orderInfo->userPaymentAccount->isNotEmpty()) &&
            $paymentAccount = $orderInfo->userPaymentAccount->first()) {
            if (isset($paymentAccount->conn_config['ali_pay_account']) && isset($paymentAccount->conn_config['pid'])) {
                $result['friend_url'] = AppTool::getAddFriendUrl(
                    $paymentAccount->conn_config['pid'],
                    $paymentAccount->conn_config['ali_pay_account']
                );
            }
        }
        $result['payment_type'] = $orderInfo->payment_type;

        return $result;
    }
}
