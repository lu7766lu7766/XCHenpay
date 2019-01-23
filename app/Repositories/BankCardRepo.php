<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/19
 * Time: 下午 06:34
 */

namespace App\Repositories;

use App\Constants\Account\AccountStatusConstants;
use App\Models\Account;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankCardRepo
{
    /**
     * @param string $sort
     * @param int $page
     * @param int $perpage
     * @param int|null $userId
     * @param string|null $search
     * @param string|null $status
     * @return Collection
     */
    public function list(
        string $sort,
        int $page = 1,
        int $perpage = 20,
        int $userId = null,
        string $search = null,
        string $status = null
    ) {
        $result = collect();
        try {
            $query = Account::query()->with([
                'user' => function (BelongsTo $query) {
                    $query->select(['id', 'company_name']);
                }
            ]);
            if (!is_null($userId)) {
                $query->whereHas('user', function (Builder $query) use ($userId) {
                    $query->where('id', $userId);
                });
            } else {
                $query->whereHas('user');
            }
            if (!is_null($search)) {
                $query->where(function (Builder $builder) use ($search) {
                    $builder->where('name', 'like', '%' . $search . '%');
                    $builder->orWhere('account', 'like', '%' . $search . '%');
                });
            }
            if (!is_null($status)) {
                $query->where('status', $status);
            }
            $result = $query->orderBy('created_at', $sort)->forPage($page, $perpage)->get();
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $userId
     * @param string $sort
     * @param int $page
     * @param int $perpage
     * @param string|null $search
     * @param string|null $status 行卡狀態
     * @return Collection|Account[]
     */
    public function bindList(
        string $sort,
        int $page = 1,
        int $perpage = 20,
        int $userId = null,
        string $search = null,
        string $status = null
    ) {
        $result = collect();
        try {
            $query = Account::query();
            if (!is_null($userId)) {
                $query->whereHas('user', function (Builder $query) use ($userId) {
                    $query->where('id', $userId);
                });
            } else {
                $query->whereHas('user');
            }
            if (!is_null($search)) {
                $query->where(function (Builder $builder) use ($search) {
                    $builder->where('name', 'like', '%' . $search . '%');
                    $builder->orWhere('account', 'like', '%' . $search . '%');
                });
            }
            if (!is_null($status)) {
                $query->where('status', $status);
            }
            $result = $query->orderBy('created_at', $sort)->forPage($page, $perpage)->get();
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }

    /**
     * @param int|null $userId
     * @param string|null $search
     * @param string|null $status
     * @return int
     */
    public function total(int $userId = null, string $search = null, string $status = null)
    {
        $result = 0;
        try {
            $query = Account::query();
            if (!is_null($userId)) {
                $query->whereHas('user', function (Builder $query) use ($userId) {
                    $query->where('id', $userId);
                });
            }
            if (!is_null($search)) {
                $query->where(function (Builder $builder) use ($search) {
                    $builder->where('name', 'like', '%' . $search . '%');
                    $builder->orWhere('account', 'like', '%' . $search . '%');
                });
            }
            if (!is_null($status)) {
                $query->where('status', $status);
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
    public function create(
        User $user,
        string $name,
        string $bankAccount,
        string $bankName,
        string $bankBranch
    ) {
        $result = false;
        try {
            \DB::transaction(function () use ($user, $name, $bankAccount, $bankName, $bankBranch, &$result) {
                $account = $user->accounts()->create([
                    'name'        => $name,
                    'account'     => $bankAccount,
                    'bank_name'   => $bankName,
                    'bank_branch' => $bankBranch
                ]);
                if (!is_null($account)) {
                    $result = true;
                }
            });
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $result = false;
        try {
            $count = Account::query()->where('id', $id)->delete();
            if ($count > 0) {
                $result = true;
            }
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $id
     * @param array $date
     * @return int
     */
    public function update(int $id, array $date)
    {
        return Account::query()->where('id', $id)->update($date);
    }

    /**
     * @param int $id
     * @return Account|\Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id)
    {
        return Account::query()->find($id);
    }

    /**
     * @param int $id
     * @param int $userId
     * @param string|null $status
     * @return Account|null
     * @see AccountStatusConstants $status 定義請參照 AccountStatusConstants
     */
    public function findOwner(int $id, int $userId, string $status = null)
    {
        $query = Account::query()->where('id', $id)->whereHas('user', function (Builder $query) use ($userId) {
            $query->where('id', $userId);
        });
        if (!is_null($status)) {
            $query->where('status', $status);
        }

        return $query->first();
    }

    /**
     * @param int $userId
     * @param string $status
     * @return Account[]|Collection
     */
    public function getCardStatusByOwner(int $userId, string $status)
    {
        return Account::query()->where('status', $status)->whereHas('user', function (Builder $query) use ($userId) {
            $query->where('id', $userId);
        })->get();
    }
}
