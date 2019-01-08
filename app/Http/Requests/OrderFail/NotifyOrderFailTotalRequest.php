<?php

namespace App\Http\Requests\OrderFail;

use Illuminate\Foundation\Http\FormRequest;

class NotifyOrderFailTotalRequest extends FormRequest
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
    public function getKeyword()
    {
        return $this->get('keyword', null);
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
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time'   => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'keyword'    => 'sometimes|required|string',
        ];
    }
}
