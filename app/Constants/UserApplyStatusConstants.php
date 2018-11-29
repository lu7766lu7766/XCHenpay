<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/11/22
 * Time: 下午 02:08
 */

namespace App\Constants;

class UserApplyStatusConstants
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
