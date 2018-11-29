<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/11/1
 * Time: 上午 11:59
 */

namespace App\Http\Requests;

use App\Constants\UserApplyStatusConstants;
use App\Constants\UserStatusConstants;
use Illuminate\Validation\Rule;

class UsersDataAddRequest extends HandleInvalidRequest
{
    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->request['company_name'];
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->request['mobile'];
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->request['email'];
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->request['status'] ?? UserStatusConstants::ON;
    }

    /**
     * @return string
     */
    public function getApplyStatus()
    {
        return $this->request['apply_status'] ?? UserApplyStatusConstants::OFF;
    }

    /**
     * @return string
     */
    public function getQQId()
    {
        return $this->request['QQ_id'];
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->request['password'];
    }

    /**
     * @return string
     */
    public function getPasswordConfirm()
    {
        return $this->request['password_confirm'];
    }

    /**
     * @return int
     */
    public function getRoleId()
    {
        return $this->request['role_id'];
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
            'company_name' => 'required|string|between:1,50',
            'mobile'       => 'required|string|max:15',
            'email'        => 'required|email|unique:users,email',
            'status'       => 'required|' . Rule::in(UserStatusConstants::enum()),
            'apply_status' => 'required|' . Rule::in(UserApplyStatusConstants::enum()),
            'QQ_id'        => 'required|string|max:15',
            'password'     => 'required|same:password_confirm|between:4,16',
            'role_id'      => 'required|integer|exists:roles,id'
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
            'company_name.required' => '商户名称必填',
            'mobile.required'       => '联络电话必填',
            'email.required'        => '电子邮箱必填',
            'email.unique'          => '此电子邮箱已被注册',
            'status.required'       => '状态必填',
            'status.in'             => '状态错误',
            'apply_status.required' => '下发申请必填',
            'apply_status.in'       => '下发申请状态错误',
            'QQ_id.required'        => 'QQ号必填',
            'password.required'     => '密码必填',
            'password.same'         => '两次输入密码不同',
            'password.between'      => '密码长度要4~16',
            'role_id.required'      => '权限必填'
        ];
    }
}
