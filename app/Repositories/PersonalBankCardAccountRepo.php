<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/2/11
 * Time: 下午 07:05
 */

namespace App\Repositories;

use App\Models\BankCardAccount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PersonalBankCardAccountRepo
{
    /**
     * @param int $userId
     * @param string|null $status
     * @param string|null $search
     * @param int $page
     * @param int $perpage
     * @return BankCardAccount[]|Collection
     */
    public function list(
        int $userId,
        string $status = null,
        string $search = null,
        int $page = 1,
        int $perpage = 25
    ) {
        $query = BankCardAccount::query()->with('payment')
            ->whereHas('personal', function (Builder $subQuery) use ($userId) {
                $subQuery->where('user_id', $userId);
            });
        if (!is_null($status)) {
            $query->where('status', $status);
        }
        if (!is_null($search)) {
            $query->where(function (Builder $subQuery) use ($search) {
                $subQuery->orWhere('user_name', 'like', '%' . $search . '%');
                $subQuery->orWhere('card_no', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('id', 'desc')->forPage($page, $perpage)->get();
    }

    /**
     * @param int $userId
     * @param string|null $status
     * @param string|null $search
     * @return int
     */
    public function total(int $userId, string $status = null, string $search = null)
    {
        $query = BankCardAccount::query()->whereHas('personal', function (Builder $subQuery) use ($userId) {
            $subQuery->where('user_id', $userId);
        });
        if (!is_null($status)) {
            $query->where('status', $status);
        }
        if (!is_null($search)) {
            $query->where(function (Builder $subQuery) use ($search) {
                $subQuery->orWhere('user_name', 'like', '%' . $search . '%');
                $subQuery->orWhere('card_no', 'like', '%' . $search . '%');
            });
        }

        return $query->count();
    }

    /**
     * @param int $userId
     * @param array $data
     * @param int $paymentId
     * @param array $paymentDetail
     * @return BankCardAccount|null
     */
    public function create(int $userId, array $data, int $paymentId, array $paymentDetail = [])
    {
        try {
            $item = null;
            \DB::transaction(function () use ($data, $paymentId, $paymentDetail, &$item, $userId) {
                /** @var BankCardAccount|null $item */
                $item = BankCardAccount::query()->create($data);
                if (!is_null($item)) {
                    $item->payment()->attach($paymentId, ['payment_detail' => $paymentDetail]);
                    $item->personal()->attach($userId);
                }
            });
        } catch (\Throwable $e) {
            \Log::debug($e->getMessage());
        }

        return $item;
    }

    /**
     * @param int $userId
     * @param int $id
     * @param array $data
     * @return int
     */
    public function update(int $userId, int $id, array $data)
    {
        return BankCardAccount::query()
            ->where('id', $id)
            ->whereHas('personal', function (Builder $subQuery) use ($userId) {
                $subQuery->where('user_id', $userId);
            })->update($data);
    }

    /**
     * @param int $userId
     * @param int $id
     * @return BankCardAccount|null
     */
    public function info(int $userId, int $id)
    {
        return BankCardAccount::query()
            ->where('id', $id)
            ->whereHas('personal', function (Builder $subQuery) use ($userId) {
                $subQuery->where('user_id', $userId);
            })->first();
    }
}
