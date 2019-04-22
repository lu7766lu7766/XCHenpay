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
    //支付寶紅包
    const ALI_PAY_RED_ENVELOPE = 'aliPayRedEnvelop';
    //支付寶個人帳戶
    const ALI_APY_PERSONAL_BANK_ACCOUNT = 'aliPayPersonalBankAccount';
    //微信支付固碼收款
    const WE_CHAT_PAYEE_QR_CODE = 'weChatPayeeQRCode';
    //雲閃付固碼收款
    const QUICK_PASS_PAYEE_QR_CODE = 'QuickPassPayeeQRCode';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::ALI_PAY,
            self::WE_CHAT_PAY,
            self::UNION_PAY,
            self::QQ_PAY,
            self::ALI_PAY_RED_ENVELOPE,
            self::ALI_APY_PERSONAL_BANK_ACCOUNT,
            self::WE_CHAT_PAYEE_QR_CODE,
            self::QUICK_PASS_PAYEE_QR_CODE
        ];
    }
}
