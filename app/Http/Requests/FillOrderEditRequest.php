<?php

namespace App\Http\Requests;

use App\Constants\ErrorCode\Article\OOO1FillOrderErrorCodes;
use App\Constants\Order\OrderStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FillOrderEditRequest extends FormRequest
{
    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->get('id', null);
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->get('user_id');
    }

    /**
     * @return int
     */
    public function getPayState()
    {
        return $this->get('pay_state');
    }

    /**
     * @return string
     */
    public function getTradeServiceId()
    {
        return $this->get('trade_service_id', '');
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->get('amount');
    }

    /**
     * @return float
     */
    public function getFee()
    {
        return $this->get('fee');
    }

    /**
     * @return int
     */
    public function getPayment()
    {
        return $this->get('payment');
    }

    /**
     * @return mixed
     */
    public function getPayTime()
    {
        return $this->get('pay_time');
    }

    /**
     * @return string
     */
    public function getRemark()
    {
        return $this->get('remark', '');
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
            'id'               => 'sometimes|required|integer|min:1',
            'user_id'          => 'required|integer|min:1',
            'payment'          => [
                'required',
                'integer',
                Rule::exists('payments', 'i6pay_id')
            ],
            'pay_state'        => ['required', Rule::in(OrderStatusConstants::fillOrderEnum())],
            'trade_service_id' => 'sometimes|required|string',
            'amount'           => 'required|numeric',
            'fee'              => 'required|numeric',
            'pay_time'         => 'required|date_format:Y-m-d H:i:s',
            'remark'           => 'sometimes|required|string'
        ];
    }

    public function messages()
    {
        return [
            'pay_state.in'   => OOO1FillOrderErrorCodes::PAY_STATE_NOT_SUPPORT,
            'payment.exists' => OOO1FillOrderErrorCodes::PAYMENT_NOT_EXISTS,
        ];
    }
}
