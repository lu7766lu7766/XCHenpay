<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/28
 * Time: 下午 01:54
 */

namespace App\Constants\BankChannel;

class BankChannelConstants
{
    const ALI_PAY = '支付宝';
    const WECHAT_PAY = '微信';
    const UNION_PAY = '银联卡';
    const QQ_PAY = 'QQ钱包';
    const JIN_DONG_PAY = '京东支付';

    /**
     * @return array
     */
    public static function enum(): array
    {
        return [
            self::ALI_PAY,
            self::WECHAT_PAY,
            self::UNION_PAY,
            self::QQ_PAY,
            self::JIN_DONG_PAY
        ];
    }
}
