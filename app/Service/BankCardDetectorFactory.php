<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/30
 * Time: 下午 03:34
 */

namespace App\Service;

use App\Constants\Payment\PaymentConstants;
use XC\Independent\Kit\Support\Traits\Pattern\Factory;

/**
 * Class BankCardDetectorFactory
 * @package App\Service
 * @method static AbstractBankCardDetector make(string $key, array $parameters = [])
 */
class BankCardDetectorFactory
{
    use Factory;

    /**
     * @return array
     */
    public static function map(): array
    {
        return [
            PaymentConstants::ALI_PAY_BANK_CARD_CODE => AliPayBankCardDetector::class
        ];
    }
}
