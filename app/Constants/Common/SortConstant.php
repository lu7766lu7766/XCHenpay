<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/26
 * Time: 下午 12:18
 */

namespace App\Constants\Common;

class SortConstant
{
    const DESC = 'DESC';
    const ASC = 'ASC';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::DESC,
            self::ASC,
        ];
    }
}
