<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/11/1
 * Time: 上午 11:59
 */

namespace App\Http\Requests;

use App\Repositories\LendRecords;
use Illuminate\Validation\Rule;

class LendManageUpdateRequest extends HandleInvalidRequest
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->request['id'];
    }

    /**
     * @return int
     */
    public function getOperation()
    {
        return $this->request['operation'];
    }

    /**
     * Request args validate rules.
     * @link https://laravel.com/docs/master/validation lookup link and know how to write rule.
     * @return array
     * @see https://laravel.com/docs/master/validation#available-validation-rules checkout this to get more rule keyword info
     */
    protected function rules()
    {
        $lendState = [LendRecords::ACCEPT_STATE, LendRecords::DENY_STATE];

        return [
            'id'        => 'required|integer|exists:lend_records,id',
            'operation' => 'required|' . Rule::in($lendState)
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
            'id.required'        => '申请单ID必填',
            'id.numeric'         => '申请单ID为数字',
            'id.exists'          => '申请单ID不存在',
            'operation.required' => '申请单状态必填',
            'operation.numeric'  => '申请单状态为数字',
            'operation.in'       => '申请单状态不合法'
        ];
    }
}
