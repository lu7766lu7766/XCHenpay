<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BindBankCardCreateRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getValidateCode()
    {
        return $this->get('code');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * 銀行卡號
     * @return string
     */
    public function getBankAccount()
    {
        return $this->get('bank_account');
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->get('bank_name');
    }

    /**
     * @return string
     */
    public function getBankBranch()
    {
        return $this->get('bank_branch');
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
            'code'         => 'required|string',
            'name'         => 'required|string',
            'bank_account' => 'required|string',
            'bank_name'    => 'required|string',
            'bank_branch'  => 'required|string',
        ];
    }
}
