<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/15
 * Time: 上午 11:11
 */

namespace App\Repositories\User\Order;

use App\Constants\Order\OrderStatusConstants;
use App\Models\Authcode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use XC\Independent\Kit\Support\Scalar\ArrayMaster;

class ListenerRepo
{
    /**
     * @param string $companyServiceId
     * @param int $id
     * @param string $start
     * @param string $end
     * @param int|null $payState
     * @return Authcode|Collection
     */
    public function getOrderOfBankCard(
        string $companyServiceId,
        int $id,
        string $start,
        string $end,
        int $payState = null
    ) {
        $query = Authcode::query()
            ->where('company_service_id', $companyServiceId)
            ->whereHas('bankCardAccount', function (Builder $builder) use ($id) {
                $builder->where('bank_card_account.id', $id);
            })->whereBetween('created_at', [$start, $end]);
        if (!is_null($payState)) {
            $query->where('pay_state', $payState);
        }

        return $query->orderBy('id', 'DESC')->get();
    }

    /**
     * @param string $companyServiceId
     * @param string $bankCardNo
     * @param float $amount
     * @param string $start
     * @param string $end
     * @return Authcode|Collection
     */
    public function getOrderByCardNoAmountDate(
        string $companyServiceId,
        string $bankCardNo,
        float $amount,
        string $start,
        string $end
    ) {
        return Authcode::query()
            ->where('company_service_id', $companyServiceId)
            ->whereIn('pay_state', [OrderStatusConstants::ALL_DONE_CODE, OrderStatusConstants::SUCCESS_CODE])
            ->where(\DB::raw('amount - rand_fee'), $amount)
            ->whereHas('bankCardAccount', function (Builder $builder) use ($bankCardNo) {
                $builder->where('bank_card_account.card_no', $bankCardNo);
            })->whereBetween('created_at', [$start, $end])->get();
    }

    /**
     * @param string $companyServiceId
     * @param string $start
     * @param string $end
     * @param array $paymentType
     * @param int|null $payState
     * @return Authcode[]|Collection
     */
    public function findOrders(
        string $companyServiceId,
        string $start,
        string $end,
        array $paymentType = [],
        int $payState = null
    ) {
        $query = Authcode::query()->where('company_service_id', $companyServiceId)
            ->whereBetween('created_at', [$start, $end]);
        if (ArrayMaster::isList($paymentType)) {
            $query->whereIn("payment_type", $paymentType);
        }
        if (!is_null($payState)) {
            $query->where('pay_state', $payState);
        }

        return $query->orderBy('id', 'DESC')->get();
    }
}
