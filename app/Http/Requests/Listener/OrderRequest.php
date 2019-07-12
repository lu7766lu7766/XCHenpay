<?php

namespace App\Http\Requests\Listener;

use App\Constants\Payment\PaymentConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    /**
     * @return array
     */
    public function getPaymentType()
    {
        return $this->get('payment_type', []);
    }

    /**
     * @return int|null
     */
    public function getPayState()
    {
        return $this->get('pay_state', null);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payment_type'   => 'sometimes|required|array',
            'payment_type.*' => Rule::in(PaymentConstants::enum()),
            'pay_state'      => 'sometimes|required|integer',
        ];
    }
}
