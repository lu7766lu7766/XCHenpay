<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyAccountPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function management(User $user)
    {
        return $user->inRole(RolesConstants::ADMIN) || $user->hasAccess(PermissionSubjectConstants::COMPANY_ACCOUNT);
    }
}
