<?php

namespace App\Http\Requests\Merchant;

use App\Constants\User\UserApplyStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MerchantsUpdateApplyStatusRequest extends FormRequest
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
    public function getApplyStatus()
    {
        return $this->get('apply_status');
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
            'id'           => 'integer|required',
            'apply_status' => 'required|' . Rule::in(UserApplyStatusConstants::enum())
        ];
    }
}
