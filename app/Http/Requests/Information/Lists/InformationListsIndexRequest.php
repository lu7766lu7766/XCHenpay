<?php

namespace App\Http\Requests\Information\Lists;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class InformationListsIndexRequest
 * @package App\Http\Requests\Information\Lists
 */
class InformationListsIndexRequest extends FormRequest
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
     * @return bool|null
     */
    public function getRead()
    {
        return $this->get('read', null);
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
            'read'        => 'sometimes|required|boolean',
            'page'        => 'sometimes|required|integer|min:1',
            'perpage'     => 'sometimes|required|integer|between:1,100',
        ];
    }
}
