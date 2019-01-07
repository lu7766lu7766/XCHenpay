<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/27
 * Time: 上午 11:05
 */

namespace App\Constants\PaymentFee;

class PaymentFeeStatusConstants
{
    const OFF = '0';
    const ON = '1';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::OFF,
            self::ON,
        ];
    }
}
