<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/11
 * Time: 下午 02:53
 */

namespace App\Repositories;

use App\Constants\PaymentManage\PaymentManageStatusConstants;
use App\Models\UserPaymentAccount;
use Illuminate\Support\Collection;
use XC\Independent\Kit\Support\Scalar\ArrayMaster;

class UserPaymentAccountRepo
{
    /**
     * @param string|null $status
     * @param string|null $keyword
     * @param int $page
     * @param int $perpage
     * @return UserPaymentAccount[]|Collection
     */
    public function getList(string $status = null, string $keyword = null, int $page = 1, int $perpage = 10)
    {
        return $this->getListQuery($status, $keyword)->forPage($page, $perpage)->get();
    }

    /**
     * @param int $id
     * @return UserPaymentAccount|null
     */
    public function getDetail(int $id)
    {
        return UserPaymentAccount::query()->where('id', $id)->first();
    }

    /**
     * @param string|null $status
     * @param string|null $keyword
     * @return int
     */
    public function getTotal(string $status = null, string $keyword = null)
    {
        return $this->getListQuery($status, $keyword)->count();
    }

    /**
     * @param UserPaymentAccount $orm
     * @param array $params
     * @return bool
     */
    public function store(UserPaymentAccount $orm, array $params)
    {
        try {
            $result = $orm->fill($params)->save();
        } catch (\Throwable $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function del(int $id)
    {
        $result = true;
        try {
            UserPaymentAccount::query()
                ->where('id', $id)
                ->delete();
        } catch (\Throwable $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param string|null $status
     * @param string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getListQuery(string $status = null, string $keyword = null)
    {
        $builder = UserPaymentAccount::query()
            ->withCount('authcodes');
        if (!is_null($status)) {
            $builder->where('status', $status);
        }
        if (!is_null($keyword)) {
            $builder->where('name', 'like', "%{$keyword}%");
        }

        return $builder;
    }

    /**
     * 檢查金流帳號是否不存在訂單
     * @param int $id
     * @return bool
     */
    public function isNoOrder(int $id)
    {
        return UserPaymentAccount::query()
            ->where('id', $id)
            ->whereDoesntHave('authcodes')
            ->exists();
    }

    /**
     * 取得可用金流帳號
     * @param int|null $userId
     * @param array $vendors
     * @return UserPaymentAccount[]|Collection
     */
    public function getAccount(int $userId = null, array $vendors = [])
    {
        $builder = UserPaymentAccount::query()
            ->where('status', PaymentManageStatusConstants::ON);
        is_null($userId) ? $builder->whereNull('user_id') : $builder->where('user_id', $userId);
        if (ArrayMaster::isList($vendors)) {
            $builder->whereIn('vendor', $vendors);
        }

        return $builder->get();
    }
}
