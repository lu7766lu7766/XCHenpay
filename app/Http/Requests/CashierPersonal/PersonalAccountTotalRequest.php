<?php

namespace App\Http\Requests\CashierPersonal;

use App\Constants\BankCardPayment\BankCardPaymentStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonalAccountTotalRequest extends FormRequest
{
    /**
     * @return string|null
     */
    public function getSearch()
    {
        return $this->get('search', null);
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return $this->get('status', null);
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
            'status' => 'sometimes|required|' . Rule::in(BankCardPaymentStatusConstants::enum()),
            'search' => 'sometimes|required|string',
        ];
    }
}
