<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/11/23
 * Time: 下午 12:41
 */

namespace App\Http\Requests\Account;

use App\Http\Requests\HandleInvalidRequest;

class AddAccountRequest extends HandleInvalidRequest
{
    /**
     * @return string
     */
    public function getValidateCode()
    {
        return $this->request['code'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->request['name'];
    }

    /**
     * 銀行卡號
     * @return string
     */
    public function getBankAccount()
    {
        return $this->request['bank_account'];
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->request['bank_name'];
    }

    /**
     * @return string
     */
    public function getBankBranch()
    {
        return $this->request['bank_branch'];
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
            'code'         => 'required|string',
            'name'         => 'required|string',
            'bank_account' => 'required|string',
            'bank_name'    => 'required|string',
            'bank_branch'  => 'required|string',
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
            'code.required'         => 'code为必填',
            'code.integer'          => 'code为string',
            'name.required'         => 'name为必填',
            'name.string'           => 'name为string',
            'bank_account.required' => 'bank_account为必填',
            'bank_account.string'   => 'bank_account为string',
            'bank_name.required'    => 'bank_name为必填',
            'bank_name.string'      => 'bank_name为string',
            'bank_branch.required'  => 'bank_branch为必填',
            'bank_branch.string'    => 'bank_branch为string',
        ];
    }
}
