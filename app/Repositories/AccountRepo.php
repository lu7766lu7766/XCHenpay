<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/11/21
 * Time: 下午 04:52
 */

namespace App\Repositories;

use App\Models\Account;
use App\Models\verifyCode;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AccountRepo
{
    /**
     * @return Collection|User[]
     */
    public function companyInfo()
    {
        try {
            $result = User::query()->whereHas('roles', function (Builder $builder) {
                $builder->where('slug', 'user');
            })->get();
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
            $result = collect();
        }

        return $result;
    }

    /**
     * @param int $userId
     * @param string $sort
     * @param int $page
     * @param int $perpage
     * @param string|null $search
     * @return Collection|Account[]
     */
    public function accountData(
        int $userId,
        string $sort,
        int $page = 1,
        int $perpage = 20,
        string $search = null
    ) {
        $result = collect();
        try {
            $query = Account::query()
                ->where('user_id', $userId);
            if (!is_null($search)) {
                $query->where(function (Builder $builder) use ($search) {
                    $builder->where('name', 'like', '%' . $search . '%');
                    $builder->orWhere('account', 'like', '%' . $search . '%');
                });
            }
            $result = $query->orderBy('created_at', $sort)->forPage($page, $perpage)->get();
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $userId
     * @param string|null $search
     * @return int
     */
    public function total(
        int $userId,
        string $search = null
    ) {
        $result = 0;
        try {
            $query = Account::query()
                ->where('user_id', $userId);
            if (!is_null($search)) {
                $query->where(function (Builder $builder) use ($search) {
                    $builder->where('name', 'like', '%' . $search . '%');
                    $builder->orWhere('account', 'like', '%' . $search . '%');
                });
            }
            $result = $query->count();
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }

    /**
     * @param User $user
     * @param string $name
     * @param string $bankAccount
     * @param string $bankName
     * @param string $bankBranch
     * @return bool
     * @throws \Throwable
     */
    public function addAccount(
        User $user,
        string $name,
        string $bankAccount,
        string $bankName,
        string $bankBranch
    ) {
        $result = true;
        try {
            \DB::transaction(function () use ($user, $name, $bankAccount, $bankName, $bankBranch, &$result) {
                $user->addAccount(new Account([
                    'name'        => $name,
                    'account'     => $bankAccount,
                    'bank_name'   => $bankName,
                    'bank_branch' => $bankBranch
                ]));
                activity($user->email)->causedBy($user)->log('绑订了一笔帐号');
            });
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
            $result = false;
        }

        return $result;
    }

    /**
     * @param int $bankAccountId
     * @param int $userId |null
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function delete(int $bankAccountId, int $userId = null)
    {
        $result = null;
        try {
            $query = Account::query()
                ->with('user');
            if (!is_null($userId)) {
                $query->whereHas('user', function (Builder $builder) use ($userId) {
                    $builder->where('users.id', $userId);
                });
            }
            $result = $query->find($bankAccountId);
            if (!is_null($result)) {
                $result->delete();
            }
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
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
                ->first();
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }
}
