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
    /** 系統通知 */
    const SYSTEM = 0;
    /** 補單通知 */
    const FILL_ORDER = 1;
    /** 异动通知 */
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


