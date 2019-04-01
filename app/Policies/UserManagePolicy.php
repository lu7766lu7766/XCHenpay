<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserManagePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function management(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::USER_MANAGE);
    }
}
