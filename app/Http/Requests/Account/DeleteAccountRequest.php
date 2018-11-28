<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/11/23
 * Time: 下午 05:34
 */

namespace App\Http\Requests\Account;

use App\Http\Requests\HandleInvalidRequest;

class DeleteAccountRequest extends HandleInvalidRequest
{
    /**
     * @return int|null
     */
    public function getUserId()
    {
        return $this->request['user_id'] ?? null;
    }

    /**
     * 銀行帳號流水號
     * @return int
     */
    public function getBankAccountId()
    {
        return $this->request['bank_account_id'];
    }

    /**
     * Request args validate rules.
     * @link https://laravel.com/docs/master/validation lookup link and know how to write rule.
     * @return array
     * @see https://laravel.com/docs/master/validation#available-validation-rules checkout this to get more rule keyword info
     */
    protected function rules()
    {
        return [
            'user_id'         => 'sometimes|required|integer',
            'bank_account_id' => 'required|integer',
        ];
    }

    /**
     * Request args validate msg on fail.
     * @link https://laravel.com/docs/master/validation lookup link and know how to write message.
     * @return array
     * @see https://laravel.com/docs/master/validation#customizing-the-error-messages checkout this to get more message info
     * @see https://laravel.com/docs/master/validation#working-with-error-messages checkout this to get more message info
     */
    protected function messages()
    {
        return [
            'user_id.integer'          => 'user_id为int',
            'bank_account_id.required' => 'bank_account_id为必填',
            'bank_account_id.integer'  => 'bank_account_id为int',
        ];
    }
}
