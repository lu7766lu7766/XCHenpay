<?php

namespace App\Http\Requests\CashierCompany;

use App\Constants\BankCardPayment\BankCardPaymentStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyAccountUpdateRequest extends FormRequest
{
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
    public function getId()
    {
        return $this->get('id');
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
            'id'             => 'required|integer',
            'status'         => 'required|' . Rule::in(BankCardPaymentStatusConstants::enum()),
            'minimum_amount' => 'required|integer|max:' . $this->getMaximumAmount(),
            'maximum_amount' => 'required|integer',
        ];
    }
}
