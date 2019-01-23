<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HeaderInfoPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function pendingCount(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::BANK_CARD_LIST) || $user->inRole(RolesConstants::ADMIN);
    }
}
