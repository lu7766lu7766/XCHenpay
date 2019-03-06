<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/28
 * Time: 下午 03:39
 */

namespace App\Repositories;

use App\Models\BankCardAccount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BankCardAccountRepo
 * @package App\Repositories
 */
class BankCardAccountRepo
{
    /**
     * @param string|null $status
     * @param string|null $search
     * @param int $page
     * @param int $perpage
     * @return Collection|BankCardAccount[]
     */
    public function companyList(
        string $status = null,
        string $search = null,
        int $page = 1,
        int $perpage = 25
    ) {
        $query = BankCardAccount::query()->with('payment')->whereDoesntHave('personal');
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
     * @param string|null $status
     * @param string|null $search
     * @return int
     */
    public function companyTotal(string $status = null, string $search = null)
    {
        $query = BankCardAccount::query()->whereDoesntHave('personal');
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
     * @param int $id
     * @return BankCardAccount|null
     */
    public function companyInfo(int $id)
    {
        return BankCardAccount::with('payment')->whereDoesntHave('personal')->find($id);
    }

    /**
     * @param array $data
     * @param int $paymentId
     * @param array $paymentDetail
     * @return BankCardAccount|null
     */
    public function create(array $data, int $paymentId, array $paymentDetail = [])
    {
        try {
            $item = null;
            \DB::transaction(function () use ($data, $paymentId, $paymentDetail, &$item) {
                /** @var BankCardAccount|null $item */
                $item = BankCardAccount::query()->create($data);
                if (!is_null($item)) {
                    $item->payment()->attach($paymentId, ['payment_detail' => $paymentDetail]);
                }
            });
        } catch (\Throwable $e) {
            \Log::debug($e->getMessage());
        }

        return $item;
    }

    /**
     * @param int $id
     * @param array $data
     * @return int
     */
    public function companyUpdate(int $id, array $data)
    {
        return BankCardAccount::query()->whereDoesntHave('personal')->where('id', $id)->update($data);
    }

    /**
     * @param int $id
     * @return BankCardAccount|null
     */
    public function infoWithPayment(int $id)
    {
        return BankCardAccount::with('payment')->find($id);
    }
}
