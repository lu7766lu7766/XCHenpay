<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/15
 * Time: 下午 02:55
 */

namespace App\Factory\Payment\Manage;

class AliPayPersonalBankAccount extends AbstractConnConfig
{
    /**
     * 各金流管理驗證規則
     * @return array
     */
    public function rules(): array
    {
        return [
            'conn_config.ali_pay_account'  => 'required|string',
            'conn_config.qr_code_url'      => 'required|string',
            'conn_config.qr_code_url_time' => 'required|string',
        ];
    }
}
