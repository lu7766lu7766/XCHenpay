<?php

namespace App\Policies;

use App\Constants\PermissionSubjectConstants;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class OrderQueryPolicy, Handle 注單查詢功能的權限控管
 * @package App\Policies
 */
class OrderQueryPolicy
{
    use HandlesAuthorization;

    /**
     * 完全控制
     * @param User $user
     * @return bool
     */
    public function dominate(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::ORDER_QUERY_DOMINATE);
    }

    /**
     * 修改
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::ORDER_QUERY_UPDATE)
            || $user->hasAccess(PermissionSubjectConstants::ORDER_QUERY_DOMINATE);
    }

    /**
     * 查詢單筆
     * @param User $user
     * @return bool
     */
    public function showState(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::ORDER_QUERY_SHOW_STATE)
            || $user->hasAccess(PermissionSubjectConstants::ORDER_QUERY_DOMINATE);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function manage(User $user)
    {
        return $user->hasAccess(PermissionSubjectConstants::ORDER_QUERY_MANAGE)
            || $user->hasAccess(PermissionSubjectConstants::ORDER_QUERY_DOMINATE);
    }
}
