<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/20
 * Time: 下午 04:27
 */

namespace App\Repositories;

use App\Constants\Roles\RolesConstants;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use XC\Independent\Kit\Support\Scalar\ArrayMaster;

class UserRepo
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

    /**
     * 取得商戶列表資訊
     * @param int $page
     * @param int $perpage
     * @param null|string $status
     * @param null|string $applyStatus
     * @param null|string $keyword
     * @return User[]
     */
    public function getUserData(
        int $page = 1,
        int $perpage = 10,
        string $status = null,
        string $applyStatus = null,
        $keyword = null
    ) {
        $builder = $this->getUserDataQuery($status, $applyStatus, $keyword);

        return $builder->forPage($page, $perpage)->get();
    }

    /**
     * 取得商戶列表資料總筆數
     * @param null|string $status
     * @param null|string $applyStatus
     * @param null|string $keyword
     * @return int
     */
    public function getUserDataTotal(string $status = null, string $applyStatus = null, string $keyword = null)
    {
        $builder = $this->getUserDataQuery($status, $applyStatus, $keyword);

        return $builder->count();
    }

    /**
     * 取得指定商戶列表資料明細
     * @param int $userId
     * @return User
     */
    public function getUserDataDetail(int $userId)
    {
        return User::query()->with([
            'roles' => function (Relation $builder) {
                $builder->select([
                    'id',
                    'name',
                ]);
            }
        ])
            ->where('id', $userId)
            ->first();
    }

    /**
     * 查詢已刪除帳號列表
     * @param int $page
     * @param int $perpage
     * @return mixed
     */
    public function getTrashedUserData(int $page = 1, int $perpage = 10)
    {
        return $this->getTrashedDataQuery()
            ->forPage($page, $perpage)
            ->get();
    }

    /**
     * 查詢已刪除帳號列表總筆數
     * @return mixed
     */
    public function getTrashedUserDataTotal()
    {
        return $this->getTrashedDataQuery()->count();
    }

    /**
     * 取得已刪除帳號列表語法
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private function getTrashedDataQuery()
    {
        return User::onlyTrashed()
            ->select(
                'id',
                'company_name',
                'email',
                'deleted_at'
            );
    }

    /**
     * 取得商路列表資訊查詢語法
     * @param null|string $status
     * @param null|string $applyStatus
     * @param null|string $keyword
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private function getUserDataQuery(string $status = null, string $applyStatus = null, string $keyword = null)
    {
        $builder = User::query();
        if (!is_null($status)) {
            $builder->where('status', $status);
        }
        if (!is_null($applyStatus)) {
            $builder->where('apply_status', $applyStatus);
        }
        if (!is_null($keyword)) {
            $builder->where('company_name', $keyword);
        }

        return $builder->select(
            'id',
            'email',
            'QQ_id',
            'company_name',
            'status',
            'apply_status'
        );
    }

    /**
     * @param int $page
     * @param int $perpage
     * @return User[]|Collection
     */
    public function getWhitelist(int $page = 1, int $perpage = 10)
    {
        return User::with('whitelist')->orderBy('id', 'DESC')->forPage($page, $perpage)->get();
    }

    /**
     * @return int
     */
    public function total()
    {
        return User::count();
    }

    /**
     * 取得商戶
     * @return Collection|User[]
     */
    public function getCompanies()
    {
        return User::query()->whereHas('roles', function (Builder $builder) {
            $builder->where('slug', RolesConstants::USER);
        })->get();
    }

    /**
     * @param int $page
     * @param int $perpage
     * @param string|null $status
     * @param string|null $keyword
     * @return User[]|Collection
     */
    public function getUserDataWithoutUserRole(
        int $page = 1,
        int $perpage = 10,
        string $status = null,
        string $keyword = null
    ) {
        $builder = $this->getUserDataWithoutUserRoleQuery($status, $keyword);

        return $builder->forPage($page, $perpage)->get();
    }

    /**
     * @param string $status
     * @param string $keyword
     * @return int
     */
    public function getUserDataWithoutUserRoleTotal(string $status = null, string $keyword = null)
    {
        return $this->getUserDataWithoutUserRoleQuery($status, $keyword)->count();
    }

    /**
     * @param string|null $status
     * @param string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private function getUserDataWithoutUserRoleQuery(string $status = null, string $keyword = null)
    {
        $builder = User::query()->with(
            [
                'roles' => function (Relation $builder) {
                    $builder->select(
                        [
                            'id',
                            'name',
                            'slug'
                        ]
                    );
                }
            ]
        )
            ->whereHas('roles', function (Builder $builder) {
                $builder->where('slug', '<>', RolesConstants::USER);
            });
        if (!is_null($status)) {
            $builder->where('status', $status);
        }
        if (!is_null($keyword)) {
            $builder->where(function (Builder $builder) use ($keyword) {
                $builder->where('company_name', 'like', '%' . $keyword . '%')
                    ->orwhere('email', 'like', '%' . $keyword . '%');
            });
        }

        return $builder->select(
            'id',
            'company_name',
            'email',
            'status'
        );
    }

    /**
     * 取得指定帳號資料明細(排除商戶角色)
     * @param int $userId
     * @return User|null
     */
    public function getUserDataDetailWithoutUserRole(int $userId)
    {
        return User::query()->with(
            [
                'roles' => function (Relation $builder) {
                    $builder->select(
                        [
                            'name',
                            'slug'
                        ]
                    );
                }
            ]
        )
            ->whereHas('roles', function (Builder $builder) {
                $builder->where('slug', '<>', 'user');
            })
            ->where('id', $userId)
            ->select(
                [
                    'id',
                    'company_name',
                    'email',
                    'status'
                ]
            )
            ->first();
    }

    /**
     * 取得指定帳號資料(排除商戶角色)
     * @param int $userId
     * @return User|null
     */
    public function getUserDataWithoutUserRoleByUserId(int $userId)
    {
        return User::query()->whereHas('roles', function (Builder $builder) {
            $builder->where('slug', '<>', 'user');
        })
            ->where('id', $userId)
            ->select(
                [
                    'id',
                    'company_name',
                    'email',
                    'status'
                ]
            )
            ->first();
    }

    /**
     * 新增帳號
     * @param array $insertInfo
     * @param int $roleId
     * @return User
     */
    public function userAdd(array $insertInfo, int $roleId)
    {
        /**@var User $user */
        $user = Sentinel::register($insertInfo, true);
        $user->roles()->attach($roleId);

        return $user;
    }

    /**
     * 更新帳號
     * @param User $user
     * @param array $updateInfo
     * @param array $roleIdList
     * @return bool
     */
    public function userUpdate(User $user, array $updateInfo, array $roleIdList)
    {
        $result = true;
        try {
            $user->fill($updateInfo)->save();
            $user->roles()->sync($roleIdList);
        } catch (\Throwable $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * 刪除帳號
     * @param int $userId
     * @return bool
     */
    public function userDel(int $userId)
    {
        $result = true;
        try {
            User::destroy($userId);
            Activation::where('user_id', $userId)->delete();
        } catch (\Throwable $e) {
            $result = false;
        }

        return $result;
    }
}
