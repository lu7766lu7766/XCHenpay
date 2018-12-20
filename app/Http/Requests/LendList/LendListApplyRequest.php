<?php

namespace App\Http\Requests\LendList;

use Illuminate\Foundation\Http\FormRequest;

class LendListApplyRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getTargetId()
    {
        return $this->get('target_id');
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->get('amount');
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->get('note', '');
    }

    /**
     * @return string
     */
    public function getValidateCode()
    {
        return $this->get('code');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'target_id' => 'required|integer',
            'amount'    => 'required|integer|between:' .
                config('constants.apply.min') . ',' . config('constants.apply.max'),
            'note'      => 'sometimes|required|string',
            'code'      => 'required|string',
        ];
    }
}
