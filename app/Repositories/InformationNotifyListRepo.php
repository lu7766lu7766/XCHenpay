<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/2/12
 * Time: 下午 01:51
 */

namespace App\Repositories;

use App\Models\InformationNotify;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class InformationNotifyListRepo
{
    /**
     * 訊息列表Query
     * @param int $userId
     * @return Builder
     */
    private function getListQuery(int $userId)
    {
        return InformationNotify::query()->where(function (Builder $query) use ($userId) {
            $query->WhereHas('roleGroup', function (Builder $subQuery) use ($userId) {
                $subQuery->whereHas('users', function (Builder $q) use ($userId) {
                    $q->where('users.id', $userId);
                });
            })->orWhereHas('personal', function (Builder $subQuery) use ($userId) {
                $subQuery->where('users.id', $userId);
            });
        })->whereDoesntHave('beenDeleteByUser', function (Builder $subQuery) use ($userId) {
            $subQuery->where('users.id', $userId);
        });
    }

    /**
     * 訊息列表清單
     * @param int $userId
     * @param int|null $categoryId
     * @param int $page
     * @param int $perpage
     * @param bool|null $read
     * @return Collection|InformationNotify[]
     */
    public function list(
        int $userId,
        int $categoryId = null,
        int $page = 1,
        int $perpage = 25,
        bool $read = null
    ) {
        $query = $this->getListQuery($userId);
        $query->with([
            'category',
            'seenByUser' => function (BelongsToMany $query) use ($userId) {
                $query->where('users.id', $userId);
            }
        ]);
        if (!is_null($categoryId)) {
            $query->where('category_id', $categoryId);
        }
        if (!is_null($read)) {
            if ($read) {
                $query->whereHas('seenByUser', function (Builder $subQuery) use ($userId) {
                    $subQuery->where('users.id', $userId);
                });
            } else {
                $query->whereDoesntHave('seenByUser', function (Builder $subQuery) use ($userId) {
                    $subQuery->where('users.id', $userId);
                });
            }
        }

        return $query->orderBy('id', 'DESC')->forPage($page, $perpage)->get();
    }

    /**
     * 訊息列表總數
     * @param int $userId
     * @param int|null $categoryId
     * @param bool|null $read
     * @return int
     */
    public function total(int $userId, int $categoryId = null, bool $read = null)
    {
        $query = $this->getListQuery($userId);
        if (!is_null($categoryId)) {
            $query->where('category_id', $categoryId);
        }
        if (!is_null($read)) {
            if ($read) {
                $query->whereHas('seenByUser', function (Builder $subQuery) use ($userId) {
                    $subQuery->where('users.id', $userId);
                });
            } else {
                $query->whereDoesntHave('seenByUser', function (Builder $subQuery) use ($userId) {
                    $subQuery->where('users.id', $userId);
                });
            }
        }

        return $query->count();
    }

    /**
     * @param int $id
     * @param int $userId
     * @return bool
     */
    public function deleteUserInformation(int $id, int $userId)
    {
        $result = false;
        /** @var InformationNotify|null $information */
        $information = $this->getListQuery($userId)->where('id', $id)->first();
        if (!is_null($information)) {
            try {
                $information->seenByUser()
                    ->wherePivot('user_id', $userId)
                    ->sync([$userId => ['deleted_at' => Carbon::now()]]);
                $result = true;
            } catch (\Throwable $e) {
                \Log::error($e->getMessage());
            }
        }

        return $result;
    }

    /**
     * 創建已讀資訊
     * @param int $id
     * @param int $userId
     * @return InformationNotify|null
     */
    public function createUserInformation(int $id, int $userId)
    {
        /** @var InformationNotify|null $information */
        $information = $this->getListQuery($userId)->where('id', $id)->with(['category', 'roleGroup'])->first();
        if (!is_null($information)) {
            $information->seenByUser()->wherePivot('user_id', $userId)->sync([$userId]);
            $information->load('seenByUser');
        }

        return $information;
    }
}
