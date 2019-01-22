<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/17
 * Time: 下午 02:22
 */

namespace App\Constants\Account;

class AccountStatusConstants
{
    const PENDING = 'pending';
    const REJECT = 'reject';
    const APPROVAL = 'approval';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::PENDING,
            self::REJECT,
            self::APPROVAL,
        ];
    }
}
