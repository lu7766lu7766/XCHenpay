<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;

class MerchantsDeleteRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer'
        ];
    }
}
