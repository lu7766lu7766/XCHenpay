<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/16
 * Time: 下午 06:33
 */

namespace App\Constants\Lend;

class LendStatusConstants
{
    const APPLY_CODE = 0;
    const ACCEPT_CODE = 1;
    const DENY_CODE = 2;
    const APPLY = '下发中';
    const ACCEPT = '完成下发';
    const DENY = '拒绝下发';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::APPLY_CODE  => self::APPLY,
            self::ACCEPT_CODE => self::ACCEPT,
            self::DENY_CODE   => self::DENY,
        ];
    }

    /**
     * @return array
     */
    public static function statusCode()
    {
        return [
            self::APPLY_CODE,
            self::ACCEPT_CODE,
            self::DENY_CODE,
        ];
    }

    /**
     * @param int $code
     * @return string|null
     */
    public static function mappingCode(int $code)
    {
        $list = self::enum();

        return $list[$code] ?? null;
    }
}
