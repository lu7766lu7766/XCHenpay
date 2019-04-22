<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/15
 * Time: 下午 02:55
 */

namespace App\Factory\Payment\Manage;

class WeChatPayeeQRCode extends AbstractConnConfig
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'conn_config.account'          => 'required|string',
            'conn_config.qr_code_url'      => 'required|string',
            'conn_config.qr_code_url_time' => 'required|string',
        ];
    }
}
