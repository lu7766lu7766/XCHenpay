<?php

namespace App\Http\Requests\OrderFail;

use Illuminate\Foundation\Http\FormRequest;

class NotifyOrderFailIndexRequest extends FormRequest
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
     * @return int
     */
    public function getPage()
    {
        return $this->get('page', 1);
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->get('perpage', 10);
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
            'page'       => 'sometimes|required|integer',
            'perpage'    => 'sometimes|required|integer|max:100',
            'keyword'    => 'sometimes|required|string',
        ];
    }
}
