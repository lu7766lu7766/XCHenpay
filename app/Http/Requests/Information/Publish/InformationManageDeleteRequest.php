<?php

namespace App\Http\Requests\Information\Publish;

use Illuminate\Foundation\Http\FormRequest;

class InformationManageDeleteRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->get('id');
    }

    /**
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
            'id' => 'integer|required'
        ];
    }
}
