<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\Constants\Roles\RolesConstants;
use App\Models\Authcode;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderNotifyPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Authcode $order
     * @return bool
     */
    public function notify(User $user, Authcode $order)
    {
        if ($user->inRole(RolesConstants::USER) && $user->hasAccess(PermissionSubjectConstants::CALL_NOTIFY)) {
            $result = $order->company_service_id == $user->company_service_id;
        } else {
            $result = $user->inRole(RolesConstants::ADMIN) || $user->hasAccess(PermissionSubjectConstants::CALL_NOTIFY);
        }

        return $result;
    }
}
