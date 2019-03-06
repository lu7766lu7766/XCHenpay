<?php

namespace App\Http\Requests;

class AuthCodeBankCardAccountInfoRequest extends HandleInvalidRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->request['bank_card_id'];
    }

    /**
     * @inheritdoc
     */
    protected function rules()
    {
        return [
            'bank_card_id' => 'integer|required'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function messages()
    {
        return [
            'bank_card_id.required' => 'bank_card_id must required'
        ];
    }
}
