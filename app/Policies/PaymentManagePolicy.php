<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/11
 * Time: 下午 01:28
 */

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentManagePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function management(User $user)
    {
        return $user->inRole(RolesConstants::ADMIN) || $user->hasAccess(PermissionSubjectConstants::PAYMENT_MANAGE);
    }
}
