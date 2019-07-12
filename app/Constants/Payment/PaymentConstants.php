<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/30
 * Time: 下午 03:35
 */

namespace App\Constants\Payment;

use XC\Independent\Kit\Constants\BaseConstants;

class PaymentConstants extends BaseConstants
{
    const A_PAY_UNION_H5_CODE = 18;
    const A_PAY_QUICK_CODE = 19;
    const A_PAY_ALI_SCAN_CODE = 20;
    const A_PAY_ALI_WAP_CODE = 21;
    const HTIAN_ALI_PAY_SCAN = 22;
    const HTIAN_ALI_PAY_WAP = 23;
    const WEI_SAO_PAY_ALI_TO_BANK_CARD = 25;
    const UAT_PAY_WEIXIN_SCAN_CODE = 30;
    const SILKWORM_PAY_WEIXIN_PAYEE_QR_CODE = 50;
    const RABBIT_BABY_PAY = 51;
    const DRAGON_BABY_PAY_NXYS = 52;
    const DRAGON_BABY_PAY_NXYS_ALIPAY = 53;
    const DRAGON_BABY_PAY_NXYS_WXPAY = 54;
    const SILKWORM_PAY_ALI_SCAN_CODE = 55;
    const SILKWORM_PAY_QUICK_PASS_SCAN_CODE = 56;
    const THUNDER_PAY = 70;
    const CHI_CHI_PAY_ALIPAY_H5 = 80;
    const CHI_CHI_PAY_WEIXIN_H5 = 81;
    const ALI_PAY_TO_BANK_CARD = 201;
    const ALI_PAY_FRIEND_RED_ENVELOPE_CODE = 205;
    const ALI_PAY_PERSON_BANK_ACCOUNT_CODE = 206;
    const WEIXIN_PAYEE_QR_CODE = 207;
    const ALI_PAY_PERSON_PAYEE = 209;
    const ALI_PAY_TO_BANK_CARD_PERSONAL = 210;
    const ALI_PAY_TRANSFER_OUT = 211;
    const ALI_PAY_BANK_CARD_CODE = 201;
    const ALI_PAY_RED_ENVELOPE = 205;
    const QUICK_PASS_PAYEE_QR_CODE = 208;
    const ALI_PAY_BANK_CARD_PERSONAL_CODE = 210;

    /**
     * @return array
     */
    public static function enum(): array
    {
        return [
            self::A_PAY_UNION_H5_CODE,
            self::A_PAY_QUICK_CODE,
            self::A_PAY_ALI_SCAN_CODE,
            self::A_PAY_ALI_WAP_CODE,
            self::HTIAN_ALI_PAY_SCAN,
            self::HTIAN_ALI_PAY_WAP,
            self::WEI_SAO_PAY_ALI_TO_BANK_CARD,
            self::UAT_PAY_WEIXIN_SCAN_CODE,
            self::SILKWORM_PAY_WEIXIN_PAYEE_QR_CODE,
            self::RABBIT_BABY_PAY,
            self::DRAGON_BABY_PAY_NXYS,
            self::DRAGON_BABY_PAY_NXYS_ALIPAY,
            self::DRAGON_BABY_PAY_NXYS_WXPAY,
            self::SILKWORM_PAY_ALI_SCAN_CODE,
            self::SILKWORM_PAY_QUICK_PASS_SCAN_CODE,
            self::THUNDER_PAY,
            self::CHI_CHI_PAY_ALIPAY_H5,
            self::CHI_CHI_PAY_WEIXIN_H5,
            self::ALI_PAY_TO_BANK_CARD,
            self::ALI_PAY_FRIEND_RED_ENVELOPE_CODE,
            self::ALI_PAY_PERSON_BANK_ACCOUNT_CODE,
            self::WEIXIN_PAYEE_QR_CODE,
            self::ALI_PAY_PERSON_PAYEE,
            self::ALI_PAY_TO_BANK_CARD_PERSONAL,
            self::ALI_PAY_TRANSFER_OUT,
            self::ALI_PAY_BANK_CARD_CODE,
            self::ALI_PAY_RED_ENVELOPE,
            self::QUICK_PASS_PAYEE_QR_CODE,
            self::ALI_PAY_BANK_CARD_PERSONAL_CODE,
        ];
    }
}
