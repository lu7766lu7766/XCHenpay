<?php

namespace App\Http\Requests\FeeManagement;

use Illuminate\Foundation\Http\FormRequest;

class FeeManagementInfoRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getMerchantId()
    {
        return $this->get('merchant_id');
    }

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
            'merchant_id' => 'required|integer',
            'id'          => 'required|integer',
        ];
    }
}
