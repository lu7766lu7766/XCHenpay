<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/11/1
 * Time: 上午 11:21
 */

namespace App\Service;

use App\Constants\User\UserApplyStatusConstants;
use App\Http\Requests\SystemSetting\UserAddRequest;
use App\Http\Requests\SystemSetting\UserDelRequest;
use App\Http\Requests\SystemSetting\UserDetailRequest;
use App\Http\Requests\SystemSetting\UserListRequest;
use App\Http\Requests\SystemSetting\UserTotalRequest;
use App\Http\Requests\SystemSetting\UserUpdateRequest;
use App\Repositories\ActivityRepository;
use App\Repositories\RoleRepo;
use App\Repositories\UserRepo;
use App\Traits\Singleton;
use App\User;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Sentinel;

class SystemSettingService
{
    use Singleton;
    /**
     * @var array
     */
    protected $data;

    protected function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * 查詢帳號管理列表
     * @return User[]
     */
    public function userList()
    {
        $result = null;
        try {
            $handle = UserListRequest::getHandle($this->data);
            $result = app(UserRepo::class)
                ->getUserDataWithoutUserRole(
                    $handle->getPage(),
                    $handle->getPerpage(),
                    $handle->getStatus(),
                    $handle->getKeyword()
                );
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 查詢帳號管理列表總筆數
     * @return array
     */
    public function userTotal()
    {
        $result = null;
        try {
            $handle = UserTotalRequest::getHandle($this->data);
            $total = app(UserRepo::class)
                ->getUserDataWithoutUserRoleTotal(
                    $handle->getStatus(),
                    $handle->getKeyword()
                );
            $result = ['total' => $total];
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 查詢帳號資訊明細
     * @return User|array
     */
    public function userDetail()
    {
        $result = null;
        try {
            $handle = UserDetailRequest::getHandle($this->data);
            $result = app(UserRepo::class)
                ->getUserDataDetailWithoutUserRole($handle->getId());
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 取得所有角色清單(排除商戶角色)
     * @return array|EloquentRole[]
     */
    public function getRolesList()
    {
        try {
            $result = app(RoleRepo::class)->getRoleListWithoutUserRole();
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 帳號新增
     * @return array
     */
    public function userAdd()
    {
        $result = [];
        try {
            $handle = UserAddRequest::getHandle($this->data);
            $insert = [
                'email'              => $handle->getEmail(),
                'password'           => $handle->getPassword(),
                'status'             => $handle->getStatus(),
                'apply_status'       => UserApplyStatusConstants::OFF,
                'QQ_id'              => '',
                'company_name'       => $handle->getCompanyName(),
                'mobile'             => '',
                'company_service_id' => '',
                'lend_fee'           => 0,
                'sceret_key'         => ''
            ];
            \DB::transaction(function () use ($insert, $handle, &$result) {
                $role = app(RoleRepo::class)->getRoleWithoutUserRoleByRoleId($handle->getRoleId());
                if (!is_null($role)) {
                    /**@var User $user */
                    $user = app(UserRepo::class)->userAdd($insert, $handle->getRoleId());
                    if ($user) {
                        app(ActivityRepository::class)
                            ->addActivityLog($user->email, $user, Sentinel::getUser()->email . '建立新的' . $role->name);
                        $result = $user->setRelation('roles', $role);
                    } else {
                        $result = ["code" => 1001, "data" => []];
                    }
                } else {
                    throw new \Exception();
                }
            });
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 更新帳號資訊
     * @return array
     */
    public function userUpdate()
    {
        $result = [];
        try {
            $handle = UserUpdateRequest::getHandle($this->data);
            $updateInfo = [
                'company_name' => $handle->getCompanyName(),
                'email'        => $handle->getEmail(),
                'status'       => $handle->getStatus()
            ];
            $userRepo = app(UserRepo::class);
            $user = $userRepo->getUserDataWithoutUserRoleByUserId($handle->getId());
            if (!is_null($handle->getPassword())) {
                $updateInfo['password'] = Hash::make($handle->getPassword());
            }
            if ($user) {
                \DB::transaction(function () use ($updateInfo, $handle, $user, $userRepo, &$result) {
                    $status = $userRepo->userUpdate($user, $updateInfo, [$handle->getRoleId()]);
                    if ($status) {
                        app(ActivityRepository::class)
                            ->addActivityLog($user->email, $user, '更新了联络信息');
                    } else {
                        $result = ["code" => 1001, "data" => []];
                    }
                });
            } else {
                $result = ["code" => 1001, "data" => []];
            }
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 刪除帳號
     * @return array
     */
    public function userDel()
    {
        $result = [];
        try {
            $handle = UserDelRequest::getHandle($this->data);
            $userRepo = app(UserRepo::class);
            $user = $userRepo->getUserDataWithoutUserRoleByUserId($handle->getId());
            if (is_null($user) || $user->id === Sentinel::getUser()->id || $user->email == 'admin@admin.com') {
                return ["code" => 1001, "data" => []];
            }
            \DB::transaction(function () use ($user, $userRepo, &$result) {
                $status = $userRepo->userDel($user->id);
                if ($status) {
                    app(ActivityRepository::class)
                        ->addActivityLog($user->email, $user, 'User deleted by ' . Sentinel::getUser()->email);
                } else {
                    $result = ["code" => 1001, "data" => []];
                }
            });
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }
}
