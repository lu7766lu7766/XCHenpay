<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/21
 * Time: 下午 06:05
 */

namespace App\Service;

use App\Constants\Roles\RolesConstants;
use App\Http\Requests\Merchant\MerchantsCreateRequest;
use App\Http\Requests\Merchant\MerchantsDeleteRequest;
use App\Http\Requests\Merchant\MerchantsIndexRequest;
use App\Http\Requests\Merchant\MerchantsInfoRequest;
use App\Http\Requests\Merchant\MerchantsTotalRequest;
use App\Http\Requests\Merchant\MerchantsUpdateApplyStatusRequest;
use App\Http\Requests\Merchant\MerchantsUpdateRequest;
use App\Models\Payment;
use App\Repositories\ActivityRepository;
use App\Repositories\LendRecords;
use App\Repositories\RoleRepo;
use App\Repositories\UserRepo;
use App\Traits\Singleton;
use App\User;
use Hash;
use Illuminate\Support\Collection;
use Sentinel;

class MerchantsService
{
    use Singleton;

    /**
     * @param MerchantsIndexRequest $request
     * @return User[]|Collection
     */
    public function list(MerchantsIndexRequest $request)
    {
        return app(UserRepo::class)->findMerchantsList(
            $request->getPage(),
            $request->getPerpage(),
            $request->getStatus(),
            $request->getApplyStatus(),
            $request->getKeyword()
        );
    }

    /**
     * @param MerchantsInfoRequest $request
     * @return User|null
     */
    public function info(MerchantsInfoRequest $request)
    {
        return app(UserRepo::class)->findRole(
            RolesConstants::USER,
            $request->getId()
        );
    }

    /**
     * @param MerchantsUpdateRequest $request
     * @return bool
     */
    public function update(MerchantsUpdateRequest $request)
    {
        try {
            $result = false;
            \DB::transaction(function () use ($request, &$result) {
                $userRepo = app(UserRepo::class);
                $user = $userRepo->findRole(RolesConstants::USER, $request->getId());
                if (!is_null($user)) {
                    $data = [
                        'company_name' => $request->getCompanyName(),
                        'mobile'       => $request->getMobile(),
                        'email'        => $request->getEmail(),
                        'QQ_id'        => $request->getQQId(),
                        'status'       => $request->getStatus(),
                        'apply_status' => $request->getApplyStatus()
                    ];
                    if (!is_null($password = $request->getPassword())) {
                        $data['password'] = Hash::make($password);
                    }
                    if (!is_null($secretCode = $request->getSecretCode())) {
                        $data['secret_code'] = Hash::make($secretCode);
                    }
                    $result = $userRepo->update($user, $data);
                    if ($result) {
                        app(ActivityRepository::class)->addActivityLog($user->email, $user, '更新了联络信息');
                    } else {
                        throw new \Exception('更新會員資料失敗 USER ID' . $user->getKey() .
                            ' 更新資料:' . json_encode($data));
                    }
                }
            });
        } catch (\Throwable $e) {
            \Log::error('file:' . $e->getFile() . 'line:' . $e->getLine() . 'message:' . $e->getMessage());
        }

        return $result;
    }

    /**
     * @param MerchantsDeleteRequest $request
     * @return bool
     */
    public function delete(MerchantsDeleteRequest $request)
    {
        $result = false;
        try {
            /** @var User $user */
            $user = \Sentinel::getUser();
            if ($user->getKey() != $request->getId()) {
                $userRepo = app(UserRepo::class);
                $targetUser = $userRepo->findRole(
                    RolesConstants::USER,
                    $request->getId()
                );
                if (!is_null($targetUser)) {
                    \DB::transaction(function () use ($userRepo, $targetUser, $user, &$result) {
                        $result = $userRepo->delete($targetUser);
                        if ($result) {
                            app(ActivityRepository::class)
                                ->addActivityLog($targetUser->email, $targetUser, 'User deleted by ' . $user->email);
                        } else {
                            throw new \Exception('刪除失敗 USER ID:' . $targetUser->getKey());
                        }
                    });
                }
            }
        } catch (\Throwable $e) {
            \Log::error('file:' . $e->getFile() . 'line:' . $e->getLine() . 'message:' . $e->getMessage());
        }

        return $result;
    }

    /**
     * @param \App\Http\Requests\Merchant\MerchantsTotalRequest $request
     * @return int
     */
    public function total(MerchantsTotalRequest $request)
    {
        return app(UserRepo::class)->merchantsTotal(
            $request->getStatus(),
            $request->getApplyStatus(),
            $request->getKeyword()
        );
    }

    /**
     * @param MerchantsUpdateApplyStatusRequest $request
     * @return bool
     */
    public function updateApplyStatus(MerchantsUpdateApplyStatusRequest $request)
    {
        $result = false;
        $userRepo = app(UserRepo::class);
        $targetUser = $userRepo->findRole(RolesConstants::USER, $request->getId());
        if (!is_null($targetUser)) {
            $result = $userRepo->update($targetUser, ['apply_status' => $request->getApplyStatus()]);
            if ($result) {
                /** @var User $user */
                $user = Sentinel::getUser();
                app(ActivityRepository::class)
                    ->addActivityLog(
                        $targetUser->email,
                        $targetUser,
                        'User update apply_status=' . $request->getApplyStatus() . ' by ' . $user->email
                    );
            }
        }

        return $result;
    }

    /**
     * @param MerchantsCreateRequest $request
     * @return null|User
     */
    public function create(MerchantsCreateRequest $request)
    {
        try {
            $result = null;
            $insert = [
                'email'              => $request->getEmail(),
                'password'           => $request->getPassword(),
                'status'             => $request->getStatus(),
                'apply_status'       => $request->getApplyStatus(),
                'QQ_id'              => $request->getQQId(),
                'company_name'       => $request->getCompanyName(),
                'mobile'             => $request->getMobile(),
                'company_service_id' => md5(str_random(32) . env('APP_KEY')),
                'lend_fee'           => LendRecords::FEE,
                'sceret_key'         => md5(str_random(32)),
                'secret_code'        => Hash::make($request->getSecretCode()),
            ];
            \DB::transaction(function () use ($insert, $request, &$result) {
                $roles = app(RoleRepo::class)->getBySlug([RolesConstants::USER]);
                if ($roles->isNotEmpty()) {
                    $role = $roles->first();
                    /** @var User $user */
                    $user = Sentinel::getUser();
                    /**@var User $targetUser */
                    $targetUser = Sentinel::register($insert, true);
                    $targetUser->roles()->attach($role->getKey());
                    $payments = Payment::query()
                        ->select('id as payment_id', 'fee')
                        ->where('id', '>', 1)
                        ->get()
                        ->toArray();
                    $targetUser->fees()->createMany($payments);
                    app(ActivityRepository::class)
                        ->addActivityLog($targetUser->email, $targetUser, $user->email . '建立新的商户');
                    $result = $targetUser;
                }
            });
        } catch (\Throwable $e) {
            \Log::error('file:' . $e->getFile() . 'line:' . $e->getLine() . 'message:' . $e->getMessage());
        }

        return $result;
    }
}
