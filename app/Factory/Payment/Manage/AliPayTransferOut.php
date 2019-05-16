<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/5/15
 * Time: 下午 01:36
 */

namespace App\Factory\Payment\Manage;

class AliPayTransferOut extends AbstractConnConfig
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
