<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/14
 * Time: 上午 11:41
 */

namespace App\Constants\Common;

class SenderConstants
{
    const AURORA = 'aurora';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::AURORA
        ];
    }
}
