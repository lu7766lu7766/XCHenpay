<?php

namespace App\Http\Requests\Whitelist;

use Illuminate\Foundation\Http\FormRequest;

class WhitelistDeleteRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->get('user_id');
    }

    /**
     * @inheritdoc
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer'
        ];
    }
}
