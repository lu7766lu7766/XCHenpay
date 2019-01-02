<?php

namespace App\Http\Requests;

use App\Constants\Order\OrderStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FillOrderListRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getStart()
    {
        return $this->get('start');
    }

    /**
     * @return string
     */
    public function getEnd()
    {
        return $this->get('end');
    }

    /**
     * @return int
     */
    public function getCompanyServiceId()
    {
        return $this->get('company_service_id');
    }

    /**
     * @return int
     */
    public function getPayState()
    {
        return $this->get('pay_state');
    }

    /**
     * @return int
     */
    public function getPayment()
    {
        return $this->get('payment');
    }

    /**
     * @return string
     */
    public function getKeyword()
    {
        return $this->get('keyword');
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->get('page', 1);
    }

    /**
     * @return int
     */
    public function getPerpage()
    {
        return $this->get('perpage', 20);
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
            'start'              => 'required|date_format:Y-m-d H:i:s',
            'end'                => 'required|date_format:Y-m-d H:i:s|after:start',
            'company_service_id' => 'sometimes|required|string',
            'pay_state'          => ['sometimes', 'required', Rule::in(OrderStatusConstants::fillOrderEnum())],
            'payment'            => [
                'sometimes',
                'required',
                'integer',
                'min:1',
                Rule::exists('payments', 'i6pay_id')
            ],
            'keyword'            => 'sometimes|required|string|between:1,100',
            'page'               => 'sometimes|required|integer|min:1',
            'perpage'            => 'sometimes|required|integer|between:1,100',
        ];
    }
}
