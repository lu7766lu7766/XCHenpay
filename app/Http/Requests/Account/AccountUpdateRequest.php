<?php

namespace App\Http\Requests\Account;

use App\Constants\Account\AccountStatusConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountUpdateRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getId()
    {
        return $this->get('id');
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
    public function getNote()
    {
        return $this->get('note', null);
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
            'id'     => 'required|integer',
            'status' => 'required|' . Rule::in(AccountStatusConstants::enum()),
            'note'   => 'sometimes|required'
        ];
    }
}
