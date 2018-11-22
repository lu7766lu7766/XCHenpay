<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2018/11/19
 * Time: 上午 11:41
 */

namespace App\Repositories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Collection;

class ActivityRepository
{
    /**
     * @param string $start 起始日期
     * @param string $end 結束日期
     * @param string $type Class type. e.g. \App\User::class
     * @param string|null $companyName 商戶平稱,模糊比對
     * @param int|null $userId user id
     * @param int $page
     * @param int $perpage
     * @return Activity[]|Collection
     */
    public function getCauserLog(
        string $start,
        string $end,
        string $type,
        string $companyName = null,
        int $userId = null,
        int $page = 1,
        int $perpage = 20
    ) {
        $result = [];
        try {
            $builder = Activity::with(['causer'])
                ->whereBetween('created_at', [$start, $end])
                ->where('causer_type', $type);
            if (!is_null($companyName)) {
                $builder->where('log_name', 'like', "%{$companyName}%");
            }
            if (!is_null($userId)) {
                $builder->where('causer_id', $userId);
            }
            $result = $builder->forPage($page, $perpage)->get();
        } catch (\Throwable $e) {
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $start
     * @param string $end
     * @param string|null $companyName
     * @param int|null $userId
     * @return int
     */
    public function getCauserLogTotal(
        string $start,
        string $end,
        string $type,
        string $companyName = null,
        int $userId = null
    ) {
        $result = 0;
        try {
            $builder = Activity::query()
                ->whereBetween('created_at', [$start, $end])
                ->where('causer_type', $type);
            if (!is_null($companyName)) {
                $builder->where('log_name', 'like', "%{$companyName}%");
            }
            if (!is_null($userId)) {
                $builder->where('causer_id', $userId);
            }
            $result = $builder->count();
        } catch (\Throwable $e) {
            logger($e->getMessage());
        }

        return $result;
    }
}
