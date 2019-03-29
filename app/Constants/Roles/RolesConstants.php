<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/20
 * Time: 下午 04:24
 */

namespace App\Constants\Roles;

class RolesConstants
{
    //管理者
    const ADMIN = 'admin';
    //客服
    const CUSTOMER = 'customer_service';
    //财务
    const FINANCE = 'finance';
    //商户
    const USER = 'user';
    //監聽機器人
    const LISTENER = 'listener';

    /**
     * @return array
     */
    public static function enum()
    {
        return [
            self::ADMIN,
            self::CUSTOMER,
            self::FINANCE,
            self::USER,
            self::LISTENER
        ];
    }
}
