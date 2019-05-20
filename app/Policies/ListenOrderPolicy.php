<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ListenerPolicy
 * @package App\Policies
 */
class ListenOrderPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function listenOrder(User $user)
    {
        return $user->inRole(RolesConstants::LISTENER) && $user->hasAccess(PermissionSubjectConstants::LISTENER_ORDER);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function userOrderListener(User $user)
    {
        return $user->inRole(RolesConstants::USER);
    }
}
