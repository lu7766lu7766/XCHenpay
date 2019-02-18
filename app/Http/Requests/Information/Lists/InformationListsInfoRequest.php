<?php

namespace App\Http\Requests\Information\Lists;

use App\Http\Requests\HandleInvalidRequest;

class InformationListsInfoRequest extends HandleInvalidRequest
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
            'id.required' => 'id must required'
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
