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
        return $this->request['user_id'];
    }

    /**
     * @inheritdoc
     */
    protected function rules()
    {
        return [
            'user_id' => 'integer|required'
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
