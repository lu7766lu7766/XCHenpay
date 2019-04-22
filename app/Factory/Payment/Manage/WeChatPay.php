<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/15
 * Time: 下午 02:43
 */

namespace App\Factory\Payment\Manage;

class WeChatPay extends AbstractConnConfig
{
    /**
     * 各金流管理驗證規則
     * @return array
     */
    public function rules(): array
    {
        return [
            'conn_config.app_id'      => 'required|string',
            'conn_config.mch_id'      => 'required|string',
            'conn_config.private_key' => 'required|string',
        ];
    }
}
