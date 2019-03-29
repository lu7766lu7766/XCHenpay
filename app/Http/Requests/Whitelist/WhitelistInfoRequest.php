<?php

namespace App\Http\Requests\Whitelist;

use App\Http\Requests\HandleInvalidRequest;

class WhitelistInfoRequest extends HandleInvalidRequest
{
    /**
     * @return int
     */
    public function getUserId()
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
