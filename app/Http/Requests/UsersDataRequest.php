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

class UsersDataRequest extends HandleInvalidRequest
{
    /**
     * @return int
     */
    public function getPage()
    {
        return $this->request['page'] ?? 1;
    }

    /**
     * @return int
     */
    public function getPerpage()
    {
        return $this->request['perpage'] ?? 10;
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return $this->request['status'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getApplyStatus()
    {
        return $this->request['apply_status'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getKeyword()
    {
        return $this->request['keyword'] ?? null;
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
            'page'         => 'sometimes|required|integer|min:1',
            'perpage'      => 'sometimes|required|integer|between:1,100',
            'status'       => 'sometimes|required|' . Rule::in(UserStatusConstants::enum()),
            'apply_status' => 'sometimes|required|' . Rule::in(UserApplyStatusConstants::enum()),
            'keyword'      => 'sometimes|required|string'
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
            'status.in'       => '状态代码错误',
            'apply_status.in' => '下发状态代码错误',
            'direction.in'    => '状态代码错误'
        ];
    }
}
