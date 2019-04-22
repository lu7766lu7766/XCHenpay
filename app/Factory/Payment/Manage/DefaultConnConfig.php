<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/15
 * Time: 下午 06:09
 */

namespace App\Factory\Payment\Manage;

class DefaultConnConfig extends AbstractConnConfig
{
    /**
     * 驗證規則
     * @return array
     */
    public function rules(): array
    {
        return ['conn_config.*' => 'required|string'];
    }
}
