<?php

namespace App\Http\Requests\FeeList;

use App\Http\Requests\HandleInvalidRequest;

class FeeListInfoRequest extends HandleInvalidRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->request['id'];
    }

    /**
     * @inheritdoc
     */
    protected function rules()
    {
        return [
            'id' => 'integer|required'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function messages()
    {
        return [
            'id.required' => 'id must required'
        ];
    }
}
