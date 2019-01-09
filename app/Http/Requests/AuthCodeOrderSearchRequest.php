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
