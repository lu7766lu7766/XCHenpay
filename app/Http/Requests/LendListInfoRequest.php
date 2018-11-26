<?php

namespace App\Http\Requests;

class LendListInfoRequest extends HandleInvalidRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->request['id'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer'
        ];
    }

    /**
     * @inheritdoc
     * @return  array
     */
    protected function messages()
    {
        return [
            'id.required' => 'id 必填',
            'id.integer'  => 'id integer'
        ];
    }
}
