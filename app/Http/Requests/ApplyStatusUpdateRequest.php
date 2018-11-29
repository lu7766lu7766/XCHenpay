<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/11/1
 * Time: 上午 11:59
 */

namespace App\Http\Requests;

use App\Constants\UserApplyStatusConstants;
use Illuminate\Validation\Rule;

class ApplyStatusUpdateRequest extends HandleInvalidRequest
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
    public function getApplyStatus()
    {
        return $this->request['apply_status'];
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
            'id'           => 'required|integer',
            'apply_status' => 'required|' . Rule::in(UserApplyStatusConstants::enum()),
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
            'id.required'           => '商户ID必填',
            'apply_status.required' => '下发申请必填',
            'apply_status.in'       => '下发申请状态错误',
        ];
    }
}
