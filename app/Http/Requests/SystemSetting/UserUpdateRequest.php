<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/12/27
 * Time: 下午 01:10
 */

namespace App\Http\Requests\SystemSetting;

use App\Constants\Roles\RolesConstants;
use App\Constants\User\UserStatusConstants;
use App\Http\Requests\HandleInvalidRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends HandleInvalidRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->request['id'];
    }

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
    public function getEmail()
    {
        return $this->request['email'];
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->request['status'];
    }

    /**
     * @return null|string
     */
    public function getPassword()
    {
        return $this->request['password'] ?? null;
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
            'id'           => 'required|integer|exists:users,id,deleted_at,NULL',
            'company_name' => 'required|string|between:1,50',
            'email'        => 'required|email|' . Rule::unique('users')->ignore($this->getId(), 'id'),
            'status'       => 'required|' . Rule::in(UserStatusConstants::enum()),
            'password'     => 'sometimes|required|confirmed|between:4,16',
            'role_id'      => 'required|integer|' . Rule::exists('roles', 'id')->whereNot('slug', RolesConstants::USER)
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
            'id.required'           => '帐号ID必填',
            'id.exists'             => '无此帐号ID',
            'company_name.required' => '帐号名称必填',
            'email.required'        => '电子邮箱必填',
            'email.unique'          => '此电子邮箱已被注册',
            'status.required'       => '状态必填',
            'status.in'             => '状态错误',
            'password.required'     => '密码必填',
            'role_id.required'      => '权限必填',
            'role_id.exists'        => '权限不合法'
        ];
    }
}
