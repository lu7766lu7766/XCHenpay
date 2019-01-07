<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/26
 * Time: 下午 06:26
 */

namespace App\Repositories;

use App\Constants\PaymentFee\PaymentFeeStatusConstants;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class PaymentRepo
{
    /**
     * @param int $userId
     * @param bool $activate
     * @return Payment[]|Collection
     * @see PaymentFeeStatusConstants paymentFeeStatus 定義看 PaymentFeeStatusConstants
     */
    public function list(int $userId, bool $activate = true)
    {
        return Payment::with([
            'paymentFee' => function (HasMany $query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])->where('activate', $activate)->where('i6pay_id', '!=', 0)->get();
    }

    /**
     * @param int $id
     * @param int $userId
     * @param bool $activate
     * @return Payment|null
     */
    public function info(int $id, int $userId, bool $activate = true)
    {
        return Payment::with([
            'paymentFee' => function (HasMany $query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])->where('activate', $activate)->where('id', $id)->first();
    }

    /**
     * @param int $id
     * @param int $userId
     * @param float $fee
     * @param string $paymentFeeStatus
     * @return Payment|null
     */
    public function createOrUpdateByFee(
        int $id,
        int $userId,
        float $fee,
        string $paymentFeeStatus = PaymentFeeStatusConstants::ON
    ) {
        /** @var Payment|null $payment */
        $payment = Payment::query()->find($id);
        if (!is_null($payment)) {
            $payment->paymentFee()->updateOrCreate(
                ['user_id' => $userId],
                ['fee' => $fee, 'status' => $paymentFeeStatus]
            );
        }

        return $payment;
    }
}
