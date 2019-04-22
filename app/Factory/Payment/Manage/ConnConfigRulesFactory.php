<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/15
 * Time: 下午 12:43
 */

namespace App\Factory\Payment\Manage;

use App\Constants\PaymentManage\PaymentManageVendorsCodeConstants;
use App\Contract\Laravel\Validation\IDescription;
use XC\Independent\Kit\Support\Traits\Pattern\Factory;

/**
 * Class ConnConfigFactory
 * @package App\Factory\Payment\Manage
 * @method static IDescription make(string $key, array $parameters = [])
 */
class ConnConfigRulesFactory
{
    use Factory;

    /**
     * The default concrete class you want create instance.
     * @return null|string
     */
    protected static function defaultConcrete()
    {
        return DefaultConnConfig::class;
    }

    /**
     * @return array
     */
    public static function map(): array
    {
        return [
            PaymentManageVendorsCodeConstants::ALI_PAY                       => AliPay::class,
            PaymentManageVendorsCodeConstants::WE_CHAT_PAY                   => WeChatPay::class,
            PaymentManageVendorsCodeConstants::UNION_PAY                     => UnionPay::class,
            PaymentManageVendorsCodeConstants::QQ_PAY                        => QQPay::class,
            PaymentManageVendorsCodeConstants::ALI_PAY_RED_ENVELOPE          => AliPayRedEnvelope::class,
            PaymentManageVendorsCodeConstants::ALI_APY_PERSONAL_BANK_ACCOUNT => AliPayPersonalBankAccount::class,
            PaymentManageVendorsCodeConstants::WE_CHAT_PAYEE_QR_CODE         => WeChatPayeeQRCode::class,
            PaymentManageVendorsCodeConstants::QUICK_PASS_PAYEE_QR_CODE      => QuickPassPayeeQRCode::class
        ];
    }
}
