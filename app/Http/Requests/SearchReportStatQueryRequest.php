<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/11/1
 * Time: 上午 11:59
 */

namespace App\Http\Requests;

class SearchReportStatQueryRequest extends HandleInvalidRequest
{
    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->request['startDate'];
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->request['endDate'];
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
            'startDate' => 'required|date|date_format:Y-m-d H:i:s',
            'endDate'   => 'required|date|date_format:Y-m-d H:i:s|after:startDate'
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
            'startDate.required'    => '开始时间为必填',
            'startDate.date'        => '开始时间非日期格式',
            'startDate.date_format' => '开始时间日期格式错误',
            'endDate.required'      => '结束时间为必填',
            'endDate.date'          => '结束时间非日期格式',
            'endDate.date_format'   => '结束时间日期格式错误',
            'endDate.after'         => '结束时间要晚于开始时间'
        ];
    }
}
