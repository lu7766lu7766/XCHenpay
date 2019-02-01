<?php

namespace App\Http\Requests\Information\Publish;

use Illuminate\Foundation\Http\FormRequest;

class InformationPublishIndexRequest extends FormRequest
{
    /**
     * @return int|null
     */
    public function getCategoryId()
    {
        return $this->get('category_id', null);
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
        return $this->get('perpage', 25);
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
            'category_id' => 'sometimes|required|integer',
            'page'    => 'sometimes|required|integer|min:1',
            'perpage' => 'sometimes|required|integer|between:1,100',
        ];
    }
}
