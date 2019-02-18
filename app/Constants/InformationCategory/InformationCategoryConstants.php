<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/18
 * Time: 下午 03:15
 */

namespace App\Constants\InformationCategory;

class InformationCategoryConstants
{
    const SYSTEM = 0;
    const FILL_ORDER = 1;
    const TRANSACTION = 2;

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::SYSTEM,
            self::FILL_ORDER,
            self::TRANSACTION,
        ];
    }
}


