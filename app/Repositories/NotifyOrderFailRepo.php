<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/26
 * Time: 下午 04:21
 */

namespace App\Repositories;

use App\Models\ErrorLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class NotifyOrderFailRepo
{
    /**
     * @param string $startTime
     * @param string $endTime
     * @param string|null $keyword
     * @return Builder
     */
    private function getListQuery(string $startTime, string $endTime, string $keyword = null)
    {
        $query = ErrorLog::query()->whereBetween('created_at', [$startTime, $endTime]);
        if (!is_null($keyword)) {
            $query->where('log', 'like', "%{$keyword}%");
        }

        return $query;
    }

    /**
     * @param string $startTime
     * @param string $endTime
     * @param string|null $keyword
     * @param int $page
     * @param int $perpage
     * @return Collection|ErrorLog[]
     */
    public function list(string $startTime, string $endTime, string $keyword = null, int $page = 1, int $perpage = 25)
    {
        return $this->getListQuery($startTime, $endTime, $keyword)
            ->orderBy('id', 'DESC')
            ->forPage($page, $perpage)->get();
    }

    /**
     * @param string $startTime
     * @param string $endTime
     * @param string|null $keyword
     * @return int
     */
    public function total(string $startTime, string $endTime, string $keyword = null)
    {
        return $this->getListQuery($startTime, $endTime, $keyword)->count();
    }
}
