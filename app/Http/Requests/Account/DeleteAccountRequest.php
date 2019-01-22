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
     * @return int
     */
    public function getId()
    {
        return $this->request['id'];
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
            'id' => 'required|integer',
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
            'id.required' => 'id为必填',
            'id.integer'  => 'id为int',
        ];
    }
}
