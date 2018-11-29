<?php

namespace App\Http\Requests;

use App\Constants\Common\SortConstant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityHistoryRequest extends FormRequest
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
     * @return string|null
     */
    public function getKeyword()
    {
        return $this->get('keyword');
    }

    /**
     * Default 1
     * @return int
     */
    public function getPage()
    {
        return $this->get('page', 1);
    }

    /**
     * Default 20, min1 , max 100.
     * @return int
     */
    public function getPerpage()
    {
        return $this->get('perpage', 20);
    }

    /**
     * 排序
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
            'start'   => 'required|date_format:Y-m-d H:i:s',
            'end'     => 'required|date_format:Y-m-d H:i:s|after:start',
            'keyword' => 'sometimes|required|string|max:32',
            'page'    => 'sometimes|required|integer',
            'perpage' => 'sometimes|required|integer|between:1,100',
            'sort'    => 'required|' . Rule::in(SortConstant::enum()),
        ];
    }
}
