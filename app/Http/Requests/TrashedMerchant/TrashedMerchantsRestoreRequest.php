<?php

namespace App\Http\Requests\TrashedMerchant;

use Illuminate\Foundation\Http\FormRequest;

class TrashedMerchantsRestoreRequest extends FormRequest
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
            'id' => 'integer|required'
        ];
    }
}
