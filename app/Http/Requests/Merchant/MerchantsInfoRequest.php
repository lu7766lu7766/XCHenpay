<?php

namespace App\Http\Requests\Merchant;

use App\Http\Requests\HandleInvalidRequest;

class MerchantsInfoRequest extends HandleInvalidRequest
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
    protected function messages()
    {
        return [
            'user_id.required' => 'user_id must required'
        ];
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
}
