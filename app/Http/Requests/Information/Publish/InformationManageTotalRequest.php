<?php

namespace App\Http\Requests\Information\Publish;

use Illuminate\Foundation\Http\FormRequest;

class InformationManageTotalRequest extends FormRequest
{
    /**
     * @return int|null
     */
    public function getCategoryId()
    {
        return $this->get('category_id', null);
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
        ];
    }
}
