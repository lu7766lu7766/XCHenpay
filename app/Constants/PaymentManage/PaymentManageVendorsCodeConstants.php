<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/12
 * Time: 下午 06:51
 */

namespace App\Constants\PaymentManage;

class PaymentManageVendorsCodeConstants
{
    //支付寶
    const ALI_PAY = 'aliPay';
    //微信支付
    const WE_CHAT_PAY = 'weChatPay';
    //聯銀
    const UNION_PAY = 'unionPay';
    //QQ
    const QQ_PAY = 'qqPay';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::ALI_PAY,
            self::WE_CHAT_PAY,
            self::UNION_PAY,
            self::QQ_PAY
        ];
    }
}
