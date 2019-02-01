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
            'id'     => 'required|integer',
            'status' => 'required|' . Rule::in(BankCardPaymentStatusConstants::enum())
        ];
    }
}
