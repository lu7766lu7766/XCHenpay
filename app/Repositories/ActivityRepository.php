<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2018/11/19
 * Time: 上午 11:41
 */

namespace App\Repositories;

use App\Models\Activity;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ActivityRepository
{
    /**
     * @param string $start 起始日期
     * @param string $end 結束日期
     * @param string $type Class type. e.g. \App\User::class
     * @param string $sort 排序
     * @param string|null $description 描述,模糊比對
     * @param int|null $userId user id
     * @param int $page
     * @param int $perpage
     * @return Activity[]|Collection
     */
    public function getCauserLog(
        string $start,
        string $end,
        string $type,
        string $sort,
        string $description = null,
        int $userId = null,
        int $page = 1,
        int $perpage = 20
    ) {
        $result = [];
        try {
            $builder = Activity::with(['causerWithTrashed'])
                ->whereBetween('created_at', [$start, $end])
                ->where('causer_type', $type);
            if (!is_null($description)) {
                $builder->where('description', 'like', "%{$description}%");
            }
            if (!is_null($userId)) {
                $builder->where('causer_id', $userId);
            }
            $result = $builder->orderBy('created_at', $sort)->forPage($page, $perpage)->get();
        } catch (\Throwable $e) {
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $start
     * @param string $end
     * @param string $type
     * @param string|null $description
     * @param int|null $userId
     * @return int
     */
    public function getCauserLogTotal(
        string $start,
        string $end,
        string $type,
        string $description = null,
        int $userId = null
    ) {
        $result = 0;
        try {
            $builder = Activity::with(['causerWithTrashed'])
                ->whereBetween('created_at', [$start, $end])
                ->where('causer_type', $type);
            if (!is_null($description)) {
                $builder->where('description', 'like', "%{$description}%");
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

    /**
     * @param string $logName
     * @param Model $user
     * @param string $msg
     */
    public function addActivityLog(string $logName, User $user, string $msg)
    {
        activity($logName)
            ->performedOn($user)
            ->causedBy($user)
            ->log($msg);
    }
}
