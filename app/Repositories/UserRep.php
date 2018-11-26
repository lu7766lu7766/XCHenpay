<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/20
 * Time: 下午 04:27
 */

namespace App\Repositories;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use XC\Independent\Kit\Support\Scalar\ArrayMaster;

class UserRep
{
    /**
     * 角色
     * @param string $role
     * @param string $status
     * @param array $userId
     * @return User[]|Collection
     */
    public function findRole(string $role, string $status, array $userId = [])
    {
        $query = User::query()
            ->select('id', 'company_service_id', 'company_name', 'status', 'apply_status')->where('status', $status);
        if (ArrayMaster::isList($userId)) {
            $query->whereIn('id', $userId);
        }
        $query->whereHas('roles', function (Builder $query) use ($role) {
            $query->where('slug', $role);
        });

        return $query->get();
    }
}
