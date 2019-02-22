<?php

namespace App\Http\Requests\CashierManage;

use App\Constants\BankCardPayment\BankCardPaymentStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountManageTotalRequest extends FormRequest
{
    /**
     * @return int|null
     */
    public function getUserId()
    {
        return $this->get('user_id', null);
    }

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
            'user_id' => 'sometimes|required|integer',
            'status'  => 'sometimes|required|' . Rule::in(BankCardPaymentStatusConstants::enum()),
            'search'  => 'sometimes|required|string',
        ];
    }
}
