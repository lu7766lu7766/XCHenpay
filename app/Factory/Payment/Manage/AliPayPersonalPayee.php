<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/23
 * Time: 下午 02:30
 */

namespace App\Factory\Payment\Manage;

class AliPayPersonalPayee extends AbstractConnConfig
{
    /**
     * 驗證規則
     * @return array
     */
    public function rules(): array
    {
        return [
            'conn_config.ali_pay_account' => 'required|string',
            'conn_config.pid'             => 'required|string',
        ];
    }
}
