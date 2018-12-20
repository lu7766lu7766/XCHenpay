<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/13
 * Time: 下午 05:53
 */

namespace App\Constants\Common;

class VerifyType
{
    //行卡
    const ACCOUNT = 1;
    //下發申請
    const LEND_LIST = 2;

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::ACCOUNT,
            self::LEND_LIST,
        ];
    }
}
