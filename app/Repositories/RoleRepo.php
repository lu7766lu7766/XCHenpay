<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/24
 * Time: 下午 01:32
 */

namespace App\Repositories;

use App\Constants\Roles\RolesConstants;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Support\Collection;

class RoleRepo
{
    /**
     * @param array $slug
     * @return EloquentRole[]|Collection
     */
    public function findBySlug(array $slug)
    {
        return EloquentRole::query()->whereIn('slug', $slug)->get();
    }

    /**
     * 取得所有角色清單(排除商戶角色)
     * @return EloquentRole[]|Collection
     */
    public function getRoleListWithoutUserRole()
    {
        return EloquentRole::query()
            ->where('slug', '<>', RolesConstants::USER)
            ->select(['id', 'name', 'slug'])
            ->get();
    }

    /**
     * 透過role id取得角色資訊(排除商戶角色)
     * @param int $roleId
     * @return EloquentRole|null
     */
    public function getRoleWithoutUserRoleByRoleId(int $roleId)
    {
        return EloquentRole::query()
            ->where('slug', '<>', RolesConstants::USER)
            ->where('id', $roleId)
            ->select(['id', 'name', 'slug'])
            ->first();
    }
}
