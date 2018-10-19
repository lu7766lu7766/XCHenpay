<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AuthCodeOrderSearchRequest
 * @package App\Http\Requests
 */
class AuthCodeOrderSearchRequest extends FormRequest
{
    public function initialize(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::initialize(
            $query,
            $request,
            $attributes,
            $cookies,
            $files,
            $server,
            $content
        );
        request()->headers->set('Accept', 'application/json');
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
        ];
    }
}
