<?php

namespace App\Http\Requests\Information\Lists;

use Illuminate\Foundation\Http\FormRequest;

class InformationListsTotalRequest extends FormRequest
{
    /**
     * @return string|null
     */
    public function getCategoryId()
    {
        return $this->get('category_id', null);
    }

    /**
     * @return boolean|null
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
            'category_id' => 'sometimes|required',
            'read'        => 'sometimes|required|boolean',
        ];
    }
}
