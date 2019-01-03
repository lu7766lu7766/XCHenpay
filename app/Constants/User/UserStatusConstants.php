<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/20
 * Time: 下午 04:29
 */

namespace App\Constants\User;

class UserStatusConstants
{
    const ON = 'on';
    const OFF = 'off';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::ON,
            self::OFF
        ];
    }
}
