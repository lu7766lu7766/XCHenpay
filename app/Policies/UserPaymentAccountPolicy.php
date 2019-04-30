<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/26
 * Time: 下午 02:26
 */

namespace App\Policies;

use App\Constants\Roles\RolesConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPaymentAccountPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function company(User $user)
    {
        return !$user->inRole(RolesConstants::USER);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function user(User $user)
    {
        return $user->inRole(RolesConstants::USER);
    }
}
