<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/1
 * Time: 上午 11:53
 */

namespace App\Constants\PaymentManage;

class PaymentManageDepositTypeConstants
{
    const DAILY = 'daily'; //每日(00:00:00 ~ 23:59:59)
    const WEEKLY = 'weekly'; //每周(星期一 00:00:00 ~ 星期日 23:59:59)
    const MONTHLY = 'monthly'; //每月(一號 00:00:00 ~ 最後一日 23:59:59)

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::DAILY,
            self::WEEKLY,
            self::MONTHLY
        ];
    }
}
