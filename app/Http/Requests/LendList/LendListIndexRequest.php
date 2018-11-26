<?php

namespace App\Http\Requests\LendList;

use App\Constants\Common\SortConstant;
use App\Constants\Lend\LendStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LendListIndexRequest extends FormRequest
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
     * @return int
     */
    public function getStatus()
    {
        return $this->get('status');
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->get('sort');
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
            'page'       => 'sometimes|required|integer|min:1',
            'perpage'    => 'sometimes|required|integer|between:1,100',
            'status'     => 'sometimes|required|' . Rule::in(LendStatusConstants::statusCode()),
            'sort'       => 'required|' . Rule::in(SortConstant::enum())
        ];
    }
}
