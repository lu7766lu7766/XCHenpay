<?php

namespace App\Http\Requests;

use App\Constants\Lend\LendStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LendListTotalRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getStartTime()
    {
        return $this->get('start_time');
    }

    /**
     * @return string
     */
    public function getEndTime()
    {
        return $this->get('end_time');
    }

    /**
     * @return string|null
     */
    public function getNumber()
    {
        return $this->get('number', null);
    }

    /**
     * @return int|null
     */
    public function getStatus()
    {
        return $this->get('status', null);
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
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time'   => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'number'     => 'sometimes|required|string',
            'status'     => 'sometimes|required|' . Rule::in(LendStatusConstants::statusCode())
        ];
    }
}
