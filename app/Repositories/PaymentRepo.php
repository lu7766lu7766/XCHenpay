<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/2
 * Time: 上午 11:38
 */

namespace App\Repositories;

use App\Constants\PaymentFee\PaymentFeeStatusConstants;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class PaymentRepo
{
    /**
     * @return Collection|Payment[]
     */
    public function allActive()
    {
        return Payment::query()->where('i6pay_id', '!=', 0)->where('activate', 1)->get();
    }

    /**
     * @param int $userId
     * @param bool $activate
     * @return Payment[]|Collection
     */
    public function list(int $userId, bool $activate = true)
    {
        return Payment::with([
            'userFee' => function (BelongsToMany $query) use ($userId) {
                $query->where($query->getQualifiedRelatedPivotKeyName(), $userId);
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
            'userFee' => function (BelongsToMany $query) use ($userId) {
                $query->where($query->getQualifiedRelatedPivotKeyName(), $userId);
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
            $payment->userFee()->newPivotStatement()->updateOrInsert(
                ['user_id' => $userId, 'payment_id' => $payment->getKey()],
                ['fee' => $fee, 'status' => $paymentFeeStatus]
            );
        }

        return $payment;
    }

    /**
     * @param int $userId
     * @param bool $activate
     * @return Payment[]|Collection
     */
    public function getUserActivePayment(int $userId, bool $activate = true)
    {
        return Payment::query()->whereDoesntHave('userClosedPayment', function (Builder $subQuery) use ($userId) {
            $subQuery->where('users.id', $userId);
        })->where('activate', $activate)->where('i6pay_id', '!=', 0)->get();
    }
}
