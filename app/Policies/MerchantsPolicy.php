<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MerchantsPolicy
{
    use HandlesAuthorization;

    /**
     * 所有權限
     * @param User $user
     * @return bool
     */
    public function management(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::MERCHANTS);
    }

    /**
     * 瀏覽權限
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::MERCHANTS_VIEW) || $this->management($user);
    }
}
