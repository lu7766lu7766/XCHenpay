<?php

namespace App\Http\Requests\LendList;

use App\Constants\ErrorCode\Article\OOO3LendListErrorCodes;
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
    public function getSecurityCode()
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

    /**
     * Request args validate msg on fail.
     * @link https://laravel.com/docs/master/validation lookup link and know how to write message.
     * @return array
     * @see https://laravel.com/docs/master/validation#customizing-the-error-messages checkout this to get more message info
     * @see https://laravel.com/docs/master/validation#working-with-error-messages checkout this to get more message info
     */
    public function messages()
    {
        return [
            'target_id.required' => OOO3LendListErrorCodes::TARGET_ID_REQUIRED,
            'target_id.integer'  => OOO3LendListErrorCodes::TARGET_ID_MUST_INT,
            'amount.required'    => OOO3LendListErrorCodes::AMOUNT_REQUIRED,
            'amount.integer'     => OOO3LendListErrorCodes::AMOUNT_MUST_INT,
            'amount.between'     => OOO3LendListErrorCodes::OVER_LIMIT_AMOUNT_VALUE,
            'note.string'        => OOO3LendListErrorCodes::NOTE_MUST_STRING,
            'code.required'      => OOO3LendListErrorCodes::CODE_REQUIRED,
            'code.string'        => OOO3LendListErrorCodes::CODE_STRING,
        ];
    }
}
