<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/20
 * Time: 下午 04:27
 */

namespace App\Repositories;

use Activation;
use App\Constants\Common\VerifyType;
use App\Constants\Roles\RolesConstants;
use App\Models\verifyCode;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Sentinel;

class UserRepo
{
    /**
     * 角色
     * @param string $role
     * @param int $userId
     * @return User|null
     */
    public function findRole(string $role, int $userId)
    {
        $query = User::query()->whereHas('roles', function (Builder $query) use ($role) {
            $query->where('slug', $role);
        })->where('id', $userId);

        return $query->first();
    }

    /**
     * 角色
     * @param string $role
     * @param int $userId
     * @return User[]|Collection
     */
    public function getRole(string $role, int $userId = null)
    {
        $query = User::query();
        if (!is_null($userId)) {
            $query->where('id', $userId);
        }
        $query->whereHas('roles', function (Builder $query) use ($role) {
            $query->where('slug', $role);
        });

        return $query->get();
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
        ])->where('id', $userId)->first();
    }

    /**
     * 查詢已刪除帳號列表
     * @param int $page
     * @param int $perpage
     * @return User[]|Collection
     */
    public function getTrashedMerchants($page = 1, $perpage = 10)
    {
        return $this->getTrashedMerchantsQuery()
            ->forPage($page, $perpage)
            ->get();
    }

    /**
     * 查詢已刪除商家帳號列表總筆數
     * @return int
     */
    public function getTrashedMerchantsTotal()
    {
        return $this->getTrashedMerchantsQuery()->count();
    }

    /**
     * 查詢已刪除商家 Builder
     * @return Builder
     */
    private function getTrashedMerchantsQuery()
    {
        return User::query()->whereHas('roles', function (Builder $query) {
            $query->where('roles.slug', RolesConstants::USER);
        })->onlyTrashed();
    }

    /**
     * @param int $page
     * @param int $perpage
     * @param string|null $status 啟用狀態
     * @param string|null $applyStatus
     * @param string|null $keyWord
     * @return User[]|Collection
     * @see UserStatusConstants $status 啟用狀態定義 請看 UserStatusConstants
     */
    public function findMerchantsList(
        int $page = 1,
        int $perpage = 10,
        string $status = null,
        string $applyStatus = null,
        string $keyWord = null
    ) {
        return $this->getMerchantsListQuery($status, $applyStatus, $keyWord)
            ->orderBy('id', 'DESC')
            ->forPage($page, $perpage)
            ->get();
    }

    /**
     * @param string|null $status
     * @param string|null $applyStatus
     * @param string|null $keyWord
     * @return Builder
     */
    private function getMerchantsListQuery(
        string $status = null,
        string $applyStatus = null,
        string $keyWord = null
    ) {
        $query = User::query()->select(
            'id',
            'email',
            'QQ_id',
            'company_name',
            'status',
            'apply_status'
        )->whereHas('roles', function (Builder $query) {
            $query->where('roles.slug', RolesConstants::USER);
        });
        if (!is_null($status)) {
            $query->where('status', $status);
        }
        if (!is_null($applyStatus)) {
            $query->where('apply_status', $applyStatus);
        }
        if (!is_null($keyWord)) {
            $query->where('company_name', $keyWord);
        }

        return $query;
    }

    /**
     * @param string|null $status
     * @param string|null $applyStatus
     * @param string|null $keyWord
     * @return int
     */
    public function merchantsTotal(
        string $status = null,
        string $applyStatus = null,
        string $keyWord = null
    ) {
        return $this->getMerchantsListQuery($status, $applyStatus, $keyWord)->count();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findTrashed(int $id)
    {
        return User::withTrashed()->find($id);
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data)
    {
        return $user->update($data);
    }

    /**
     * @param User $user
     * @return bool|null
     * @throws \Exception
     */
    public function delete(User $user)
    {
        $user->activations()->delete();

        return $user->delete();
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
     * @param int $id
     * @return User|null
     */
    public function restore(int $id)
    {
        $user = $this->findTrashed($id);
        if (!is_null($user)) {
            $user->restore();
            $activation = Activation::create($user);
            Activation::complete($user, $activation->getCode());
        }

        return $user;
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

    /**
     * @param User $user
     * @param string $code
     * @return verifyCode|null
     */
    public function findValidateCode(User $user, string $code)
    {
        $result = null;
        try {
            $result = $user->verifyCodes()
                ->where('code', $code)
                ->where('type', VerifyType::ACCOUNT)
                ->first();
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }
}
