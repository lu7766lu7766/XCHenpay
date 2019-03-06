<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AuthCodeOrderSearchRequest
 * @package App\Http\Requests
 */
class AuthCodeOrderSearchRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getStatTime()
    {
        return $this->get('start');
    }

    /**
     * @return string
     */
    public function getEndTime()
    {
        return $this->get('end');
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
        return $this->get('perpage', 25);
    }

    /**
     * @return int|null
     */
    public function getTargetId()
    {
        return $this->get('company', null);
    }

    /**
     * @return int|null
     */
    public function getPayState()
    {
        return $this->get('pay_state', null);
    }

    /**
     * @return string|null
     */
    public function getKeyword()
    {
        return $this->get('keyword', null);
    }

    /**
     * @return int
     */
    public function getPaymentType()
    {
        return $this->get('payment_type', 0);
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->get('sort', 'created_at');
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->get('direction', 'desc');
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
            'start'        => 'required|date_format:Y-m-d H:i:s',
            'end'          => 'required|date_format:Y-m-d H:i:s|after:start',
            'page'         => 'sometimes|required|integer|min:1',
            'perpage'      => 'sometimes|required|integer|between:1,100',
            'company'      => 'sometimes|required|integer',
            'pay_state'    => 'sometimes|required|integer',
            'keyword'      => 'sometimes|required|string|between:1,100',
            'payment_type' => 'sometimes|required|integer',
            'sort'         => 'sometimes|required|in:created_at,amount',
            'direction'    => 'sometimes|required|in:desc,asc',
        ];
    }
}
