<?php

namespace App\Http\Requests\Merchant;

use App\Constants\User\UserApplyStatusConstants;
use App\Constants\User\UserStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MerchantsCreateRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->get('company_name');
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->get('mobile');
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
        return $this->get('status', UserStatusConstants::ON);
    }

    /**
     * @return string
     */
    public function getApplyStatus()
    {
        return $this->get('apply_status', UserApplyStatusConstants::OFF);
    }

    /**
     * @return string
     */
    public function getQQId()
    {
        return $this->get('QQ_id');
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->get('password');
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
            'company_name' => 'required|string|between:1,50',
            'mobile'       => 'required|alpha_num|max:15',
            'email'        => 'required|email|unique:users,email',
            'status'       => 'required|' . Rule::in(UserStatusConstants::enum()),
            'apply_status' => 'required|' . Rule::in(UserApplyStatusConstants::enum()),
            'QQ_id'        => 'required|string|max:15',
            'password'     => 'required|confirmed|between:4,16',
        ];
    }
}
