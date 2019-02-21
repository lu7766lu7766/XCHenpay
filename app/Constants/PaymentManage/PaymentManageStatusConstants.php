<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/1/31
 * Time: 下午 06:21
 */

namespace App\Constants\PaymentManage;

class PaymentManageStatusConstants
{
    //啟用
    const ON = 'on';
    //停用
    const OFF = 'off';

    /**
     * @return array
     */
    public static function enum(): array
    {
        return [
            self::ON,
            self::OFF
        ];
    }
}
