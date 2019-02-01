<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/28
 * Time: 下午 02:33
 */

namespace App\Constants\BankCardPayment;

class BankCardPaymentStatusConstants
{
    const NO = 'N';
    const YES = 'Y';

    /**
     * @return array
     */
    public static function enum(): array
    {
        return [
            self::NO,
            self::YES
        ];
    }
}
