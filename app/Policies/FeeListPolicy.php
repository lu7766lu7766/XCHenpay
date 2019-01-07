<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeeListPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function management(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::CHANNEL_FEE_LIST);
    }
}
