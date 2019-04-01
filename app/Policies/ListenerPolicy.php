<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * @todo class name 範圍很大,解法1:明確命名 ,解法2:使用namespace
 * Class ListenerPolicy
 * @package App\Policies
 */
class ListenerPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function management(User $user)
    {
        return $user->inRole(RolesConstants::LISTENER) && $user->hasAccess(PermissionSubjectConstants::LISTENER);
    }
}
