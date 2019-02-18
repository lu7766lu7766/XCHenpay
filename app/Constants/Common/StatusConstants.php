<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/18
 * Time: 下午 04:21
 */

namespace App\Constants\Common;

class StatusConstants
{
    const NO = 'N';
    const YES = 'Y';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::NO,
            self::YES,
        ];
    }
}
