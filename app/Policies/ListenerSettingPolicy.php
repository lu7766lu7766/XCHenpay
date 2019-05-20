<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ListenerSettingPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function bankTemplate(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::LISTENER_SETTING_BANK_TEMPLATE) ||
            $user->inRole(RolesConstants::ADMIN);
    }
}
