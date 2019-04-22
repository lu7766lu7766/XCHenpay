<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/15
 * Time: 下午 01:44
 */

namespace App\Contract\Laravel\Validation;

interface IDescription
{
    /**
     * 驗證規則
     * @return array
     */
    public function rules(): array;

    /**
     * @return array
     */
    public function messages(): array;
}
