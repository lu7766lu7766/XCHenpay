<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/18
 * Time: 下午 05:12
 */

namespace App\Repositories;

use App\Models\InformationNotify;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class InformationNotifyManageRepo
{
    /**
     * @param array $data
     * @return InformationNotify|Model|null
     */
    public function create(array $data)
    {
        return InformationNotify::query()->create($data);
    }

    /**
     * 管理列表清單
     * @param int|null $categoryId
     * @param int $page
     * @param int $perpage
     * @return InformationNotify[]|Collection
     */
    public function list(int $categoryId = null, int $page = 1, int $perpage = 25)
    {
        $query = InformationNotify::query()->with(['category', 'roleGroup'])->whereHas('roleGroup');
        if (!is_null($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        return $query->orderBy('id', 'DESC')->forPage($page, $perpage)->get();
    }

    /**
     * 管理列表總數
     * @param int|null $categoryId
     * @return int
     */
    public function total(int $categoryId = null)
    {
        $query = InformationNotify::query()->whereHas('roleGroup');
        if (!is_null($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        return $query->count();
    }

    /**
     * 管理列表Info
     * @param int $id
     * @return InformationNotify|null
     */
    public function manageInfo(int $id)
    {
        return InformationNotify::query()->whereHas('roleGroup')->where('id', $id)->first();
    }

    /**
     * 管理列表刪除
     * @param int $id
     * @return int
     */
    public function delete(int $id)
    {
        return InformationNotify::query()->whereHas('roleGroup')->where('id', $id)->delete();
    }

    /**
     * 對角色新增訊息
     * @param Collection $roles
     * @param InformationNotify $information
     * @return InformationNotify
     */
    public function notifyRoles(Collection $roles, InformationNotify $information)
    {
        try {
            $information->roleGroup()->attach($roles);
            $information->setRelation('roleGroup', $roles);
        } catch (\Throwable $e) {
            \Log::debug($e->getMessage());
        }

        return $information;
    }
}
