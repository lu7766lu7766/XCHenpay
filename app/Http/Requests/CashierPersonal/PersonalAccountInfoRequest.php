<?php

namespace App\Http\Requests\CashierPersonal;

use App\Http\Requests\HandleInvalidRequest;

class PersonalAccountInfoRequest extends HandleInvalidRequest
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
