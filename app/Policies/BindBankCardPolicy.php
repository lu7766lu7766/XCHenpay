<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BindBankCardPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function management(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::BIND_BANK_CARD) || $user->inRole(RolesConstants::ADMIN);
    }
}
