<?php

namespace App\Http\Requests\Merchant;

use App\Constants\User\UserApplyStatusConstants;
use App\Constants\User\UserStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MerchantsUpdateRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->get('id');
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->get('company_name');
    }

    /**
     * @return string|null
     */
    public function getMobile()
    {
        return $this->get('mobile', null);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->get('email');
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->get('status');
    }

    /**
     * @return string
     */
    public function getApplyStatus()
    {
        return $this->get('apply_status');
    }

    /**
     * @return string|null
     */
    public function getQQId()
    {
        return $this->get('QQ_id', null);
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->get('password', null);
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
            'id'           => [
                'required',
                'int',
            ],
            'company_name' => 'required|string|between:1,50',
            'mobile'       => 'required|alpha_num|max:15',
            'email'        => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->getId(), 'id')
            ],
            'status'       => 'required|' . Rule::in(UserStatusConstants::enum()),
            'apply_status' => 'required|' . Rule::in(UserApplyStatusConstants::enum()),
            'QQ_id'        => 'required|alpha_num|max:15',
            'password'     => 'sometimes|required|alpha_dash|between:4,16|confirmed',
        ];
    }
}
