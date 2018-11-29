<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/11/22
 * Time: 下午 12:27
 */

namespace App\Service;

use App\Http\Requests\ApplyStatusUpdateRequest;
use App\Http\Requests\UsersDataAddRequest;
use App\Http\Requests\UsersDataDelRequest;
use App\Http\Requests\UsersDataDetailRequest;
use App\Http\Requests\UsersDataRequest;
use App\Http\Requests\UsersDataRestoreRequest;
use App\Http\Requests\UsersDataTotalRequest;
use App\Http\Requests\UsersDataTrashedRequest;
use App\Http\Requests\UsersDataUpdateRequest;
use App\Models\Payment;
use App\Repositories\ActivityRepository;
use App\Repositories\LendRecords;
use App\Repositories\UserRepo;
use App\Traits\Singleton;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Sentinel;

class UserService
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
     * 新增商戶資訊
     * @return array
     */
    public function userDataAdd()
    {
        $result = [];
        try {
            $handle = UsersDataAddRequest::getHandle($this->data);
            $insert = [
                'email'              => $handle->getEmail(),
                'password'           => $handle->getPassword(),
                'status'             => $handle->getStatus(),
                'apply_status'       => $handle->getApplyStatus(),
                'QQ_id'              => $handle->getQQId(),
                'company_name'       => $handle->getCompanyName(),
                'mobile'             => $handle->getMobile(),
                'company_service_id' => md5(str_random(32) . env('APP_KEY')),
                'lend_fee'           => LendRecords::FEE,
                'sceret_key'         => md5(str_random(32)),
            ];
            \DB::transaction(function () use ($insert, $handle, &$result) {
                /**@var User $user */
                $user = Sentinel::register($insert, true);
                $user->roles()->attach($handle->getRoleId());
                if ($handle->getRoleId() == 4) {
                    $payments = Payment::query()
                        ->select('id as payment_id', 'fee')
                        ->where('id', '>', 1)
                        ->get()
                        ->toArray();
                    $user->fees()->createMany($payments);
                }
                app(ActivityRepository::class)
                    ->addActivityLog($user->email, $user, Sentinel::getUser()->email . '建立新的商户');
                $result = $user->load('roles');
            });
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 取得商戶列表資訊
     * @return \App\User[]|array
     */
    public function userData()
    {
        try {
            $handle = UsersDataRequest::getHandle($this->data);
            $result = app(UserRepo::class)
                ->getUserData(
                    $handle->getPage(),
                    $handle->getPerpage(),
                    $handle->getStatus(),
                    $handle->getApplyStatus(),
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
     * 取得商戶列表資料總筆數
     * @return array
     */
    public function userDataTotal()
    {
        try {
            $handle = UsersDataTotalRequest::getHandle($this->data);
            $total = app(UserRepo::class)
                ->getUserDataTotal(
                    $handle->getStatus(),
                    $handle->getApplyStatus(),
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
     * 取得商戶列表資料明細
     * @return \App\User[]|array
     */
    public function userDataDetail()
    {
        try {
            $handle = UsersDataDetailRequest::getHandle($this->data);
            $user = app(UserRepo::class)
                ->getUserDataDetail($handle->getId());
            if (is_null($user)) {
                return ["code" => 1001, "data" => []];
            }

            return $user;
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 更新商戶資料
     * @return array
     */
    public function userDataUpdate()
    {
        $result = [];
        try {
            $handle = UsersDataUpdateRequest::getHandle($this->data);
            $updateInfo = [
                'company_name' => $handle->getCompanyName(),
                'mobile'       => $handle->getMobile(),
                'email'        => $handle->getEmail(),
                'QQ_id'        => $handle->getQQId(),
                'status'       => $handle->getStatus(),
                'apply_status' => $handle->getApplyStatus()
            ];
            $user = app(UserRepo::class)->getUserDataDetail($handle->getId());
            if (!is_null($handle->getPassword())) {
                $updateInfo['password'] = Hash::make($handle->getPassword());
            }
            if ($user) {
                \DB::transaction(function () use ($updateInfo, $handle, $user) {
                    $user->fill($updateInfo)->save();
                    $user->roles()->sync([$handle->getRoleId()]);
                    app(ActivityRepository::class)
                        ->addActivityLog($user->email, $user, '更新了联络信息');
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
     * 刪除商戶資料
     * @return array
     */
    public function userDataDel()
    {
        $result = [];
        try {
            $handle = UsersDataDelRequest::getHandle($this->data);
            $user = Sentinel::findById($handle->getId());
            if (is_null($user) || $user->id === Sentinel::getUser()->id) {
                return ["code" => 1001, "data" => []];
            }
            \DB::transaction(function () use ($user) {
                User::destroy($user->id);
                Activation::where('user_id', $user->id)->delete();
                app(ActivityRepository::class)
                    ->addActivityLog($user->email, $user, 'User deleted by ' . Sentinel::getUser()->email);
            });
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 更新商戶下發狀態
     * @return array
     */
    public function applyStatusUpdate()
    {
        $result = [];
        try {
            $handle = ApplyStatusUpdateRequest::getHandle($this->data);
            $update = [
                'apply_status' => $handle->getApplyStatus()
            ];
            \DB::transaction(function () use ($handle, $update) {
                $user = User::query()->where('id', $handle->getId())->first();
                if (is_null($user)) {
                    throw new \Exception();
                }
                $user->fill($update)->update();
                app(ActivityRepository::class)
                    ->addActivityLog(
                        $user->email,
                        $user,
                        'User update apply_status=' . $handle->getApplyStatus() . ' by ' . Sentinel::getUser()->email
                    );
            });
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 查詢已刪除帳號列表
     * @return array
     */
    public function userDataTrashed()
    {
        try {
            $handle = UsersDataTrashedRequest::getHandle($this->data);
            $result = app(UserRepo::class)
                ->getTrashedUserData($handle->getPage(), $handle->getPerpage());
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 查詢已刪除帳號列表總筆數
     * @return array
     */
    public function userDataTrashedTotal()
    {
        try {
            $data = app(UserRepo::class)
                ->getTrashedUserDataTotal();
            $result = ['total' => $data];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 還原已刪除帳號
     * @return array
     */
    public function userDataRestore()
    {
        $result = [];
        try {
            $handle = UsersDataRestoreRequest::getHandle($this->data);
            \DB::transaction(function () use ($handle) {
                $user = User::withTrashed()->find($handle->getId());
                if (is_null($user)) {
                    throw new \Exception();
                }
                $user->restore();
                $activation = Activation::create($user);
                Activation::complete($user, $activation->getCode());
                app(ActivityRepository::class)
                    ->addActivityLog($user->email, $user, 'User restored by ' . Sentinel::getUser()->email);
            });
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 取得所有角色清單
     * @return array|\Illuminate\Database\Eloquent\Builder[]
     */
    public function getRolesList()
    {
        try {
            $result = EloquentRole::query()
                ->select(['id', 'name'])
                ->get();
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }
}
