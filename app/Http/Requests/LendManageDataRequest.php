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

class LendManageDataRequest extends HandleInvalidRequest
{
    /**
     * @return null|int
     */
    public function getUserId()
    {
        return $this->request['user_id'] ?? null;
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->request['start_date'];
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->request['end_date'];
    }

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
     * @return int|null
     */
    public function getLendState()
    {
        return $this->request['lend_state'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getKeyword()
    {
        return $this->request['keyword'] ?? null;
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->request['sort'] ?? 'created_at';
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->request['direction'] ?? 'desc';
    }

    /**
     * Request args validate rules.
     * @link https://laravel.com/docs/master/validation lookup link and know how to write rule.
     * @return array
     * @see https://laravel.com/docs/master/validation#available-validation-rules checkout this to get more rule keyword info
     */
    protected function rules()
    {
        $lendState = [LendRecords::APPLY_STATE, LendRecords::ACCEPT_STATE, LendRecords::DENY_STATE];

        return [
            'user_id'    => 'sometimes|required|integer',
            'start_date' => 'required|date|date_format:Y-m-d H:i:s',
            'end_date'   => 'required|date|date_format:Y-m-d H:i:s|after:start_date',
            'page'       => 'sometimes|required|integer',
            'perpage'    => 'sometimes|required|integer|between:1,100',
            'lend_state' => 'sometimes|required|' . Rule::in($lendState),
            'keyword'    => 'sometimes|required|string',
            'sort'       => 'sometimes|required|in:created_at',
            'direction'  => 'sometimes|required|in:desc,asc'
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
            'user_id.integer'        => '商户ID必填',
            'user_id.numeric'        => '商户ID为数字',
            'start_date.integer'     => '开始时间为必填',
            'start_date.date'        => '开始时间非日期格式',
            'start_date.date_format' => '开始时间日期格式错误',
            'end_date.required'      => '结束时间为必填',
            'end_date.date'          => '结束时间非日期格式',
            'end_date.date_format'   => '结束时间日期格式错误',
            'end_date.after'         => '结束时间要晚于开始时间',
            'lend_state.integer'     => '下发状态代码只能是数字',
            'lend_state.in'          => '下發狀態代碼錯誤',
            'direction.in'           => '排序方式错误'
        ];
    }
}
