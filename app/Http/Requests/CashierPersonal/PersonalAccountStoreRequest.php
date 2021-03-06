<?php

namespace App\Http\Requests\CashierPersonal;

use App\Constants\BankCardPayment\BankCardPaymentSettleDateConstants;
use App\Constants\BankCardPayment\BankCardPaymentStatusConstants;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class PersonalAccountStoreRequest
 * @package App\Http\Requests\CashierPersonal
 */
class PersonalAccountStoreRequest extends FormRequest
{
    /**
     * @return string|null
     */
    public function getCardId()
    {
        return $this->get('card_id', null);
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->get('user_name');
    }

    /**
     * @return string
     */
    public function getCardNo()
    {
        return $this->get('card_no');
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->get('bank_name');
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->get('channel');
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->get('status');
    }

    /**
     * @return int
     */
    public function getMinimumAmount()
    {
        return $this->get('minimum_amount', null);
    }

    /**
     * @return int
     */
    public function getMaximumAmount()
    {
        return $this->get('maximum_amount', null);
    }

    /**
     * @return string
     */
    public function getStatisticsType()
    {
        return $this->get('statistics_type');
    }

    /**
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->get('total_amount');
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'card_id'        => 'sometimes|required|string',
            'user_name'      => 'required|string',
            'card_no'        => 'required|string',
            'bank_name'      => 'required|string',
            'channel'        => [
                'required',
                Rule::exists('payments', 'i6pay_id')
                    ->where(
                        function (Builder $query) {
                            $query->where('i6pay_id', '!=', 0)->where('activate', 1);
                        }
                    )
            ],
            'status'         => 'required|' . Rule::in(BankCardPaymentStatusConstants::enum()),
            'minimum_amount' => 'required|integer|max:' . $this->getMaximumAmount(),
            'maximum_amount' => 'required|integer',
            'total_amount'   => 'required|integer',
            'statistics_type' => 'required|' . Rule::in(BankCardPaymentSettleDateConstants::enum()),
        ];
    }
}
