<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateCodeRequest extends FormRequest
{
    /**
     * @return string|null
     */
    public function getOldSecretCode()
    {
        return $this->get('old_secret_code', null);
    }

    /**
     * @return string|null
     */
    public function getSecretCode()
    {
        return $this->get('secret_code', null);
    }

    /**
     * @return string|null
     */
    public function getOldPassword()
    {
        return $this->get('old_password', null);
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
            'old_secret_code' => 'sometimes|required|alpha_dash',
            'secret_code'     => 'sometimes|required|alpha_dash|confirmed|min:4',
            'old_password'    => 'required_with:password|alpha_dash',
            'password'        => 'sometimes|required|alpha_dash|confirmed|min:4',
        ];
    }
}
