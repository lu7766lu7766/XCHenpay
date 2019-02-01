<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/28
 * Time: 下午 02:52
 */

namespace App\Constants\BankCardPayment;

class BankCardPaymentSettleDateConstants
{
    const DAY = 'day';
    const WEEK = 'week';
    const MONTH = 'month';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::DAY,
            self::WEEK,
            self::MONTH,
        ];
    }
}
