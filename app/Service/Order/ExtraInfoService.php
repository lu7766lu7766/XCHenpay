<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/18
 * Time: 下午 06:46
 */

namespace App\Service\Order;

use App\Constants\ErrorCode\Article\OOO1FillOrderErrorCodes;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Requests\Order\ExtraInfoRequest;
use App\Models\UserPaymentAccount;
use App\Repositories\AuthCodes;
use App\Traits\Singleton;

class ExtraInfoService
{
    use Singleton;

    /**
     * 付加備註
     * @param ExtraInfoRequest $request
     * @return bool
     * @throws ApiErrorScalarCodeException
     */
    public function add(ExtraInfoRequest $request)
    {
        $result = false;
        $order = app(AuthCodes::class)->findAuthcodesPaymentAccount($request->getTradeSeq());
        if (is_null($order)) {
            throw new ApiErrorScalarCodeException('查无订单', OOO1FillOrderErrorCodes::ORDER_NOT_EXISTS);
        }
        /** @var UserPaymentAccount $card */
        if (!is_null($card = $order->userPaymentAccount->first())) {
            if (is_null($card->authcodesPaymentAccount->extra)) {
                $order->userPaymentAccount()->updateExistingPivot(
                    $card->getKey(),
                    [
                        'extra' => ['bank_account' => $request->getAccount()]
                    ]
                );
            }
            $result = true;
        }

        return $result;
    }
}
