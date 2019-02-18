<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/18
 * Time: 下午 04:54
 */

namespace App\Service;

use App\Http\Requests\Information\Publish\InformationManageDeleteRequest;
use App\Http\Requests\Information\Publish\InformationManageIndexRequest;
use App\Http\Requests\Information\Publish\InformationManageInfoRequest;
use App\Http\Requests\Information\Publish\InformationManageStoreRequest;
use App\Http\Requests\Information\Publish\InformationManageTotalRequest;
use App\Models\InformationCategory;
use App\Models\InformationNotify;
use App\Repositories\InformationCategoryRepo;
use App\Repositories\InformationNotifyManageRepo;
use App\Repositories\RoleRepo;
use App\Traits\Singleton;
use Illuminate\Database\Eloquent\Collection;

class InformationManageService
{
    use Singleton;

    /**
     * @param InformationManageIndexRequest $request
     * @return InformationNotify[]|Collection
     */
    public function list(InformationManageIndexRequest $request)
    {
        return app(InformationNotifyManageRepo::class)->list(
            $request->getCategoryId(),
            $request->getPage(),
            $request->getPerPage()
        );
    }

    /**
     * @param InformationManageTotalRequest $request
     * @return int
     */
    public function total(InformationManageTotalRequest $request)
    {
        return app(InformationNotifyManageRepo::class)->total(
            $request->getCategoryId()
        );
    }

    /**
     * @param InformationManageStoreRequest $request
     * @return null|InformationNotify
     */
    public function notifyRole(InformationManageStoreRequest $request)
    {
        $result = null;
        $data = [
            'category_id' => $request->getCategoryId(),
            'subject'     => $request->getSubject(),
            'content'     => $request->getInfoContent(),
        ];
        try {
            \DB::transaction(function () use ($data, $request, &$result) {
                $informationRepo = app(InformationNotifyManageRepo::class);
                $notifyInfo = $informationRepo->create($data);
                if (!is_null($notifyInfo)) {
                    $notifyTarget = app(RoleRepo::class)->getBySlug($request->getRole());
                    $result = $informationRepo->notifyRoles($notifyTarget, $notifyInfo);
                }
            });
        } catch (\Throwable $e) {
            \Log::debug($e->getMessage());
        }

        return $result;
    }

    /**
     * @param InformationManageInfoRequest $request
     * @return InformationNotify|null
     */
    public function info(InformationManageInfoRequest $request)
    {
        return app(InformationNotifyManageRepo::class)->manageInfo($request->getId());
    }

    /**
     * @param InformationManageDeleteRequest $request
     * @return int
     */
    public function delete(InformationManageDeleteRequest $request)
    {
        return app(InformationNotifyManageRepo::class)->delete($request->getId());
    }

    /**
     * @return InformationCategory[]|Collection
     */
    public function category()
    {
        return app(InformationCategoryRepo::class)->all();
    }
}
