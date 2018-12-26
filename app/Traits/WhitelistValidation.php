<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/19
 * Time: 下午 02:26
 */

namespace App\Traits;

use App\Repositories\WhitelistRepo;
use App\User;

trait WhitelistValidation
{
    /**
     * @param User $user
     * @param string $ip
     * @return bool
     */
    public function isAllowIp(User $user, string $ip)
    {
        $whitelists = app(WhitelistRepo::class)->findByUser($user->getKey());

        return (is_null($whitelists) || in_array($ip, $whitelists->ip)) ? true : false;
    }
}
