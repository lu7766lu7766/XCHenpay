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
use App\Repositories\UserRepo;
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
        try {
            \DB::transaction(function () use ($request, &$result) {
                $notifyInfo = $this->create($request->getCategoryId(), $request->getSubject(), $request->getContent());
                if (!is_null($notifyInfo)) {
                    $this->attachRoles($notifyInfo, $request->getRole());
                }
            });
        } catch (\Throwable $e) {
            \Log::debug($e->getMessage());
        }

        return $result;
    }

    /**
     * @param InformationNotify $notify
     * @param array $roles
     * @return InformationNotify
     */
    public function attachRoles(InformationNotify $notify, array $roles)
    {
        $notifyTarget = app(RoleRepo::class)->getBySlug($roles);
        if ($notifyTarget->isNotEmpty()) {
            $notify = app(InformationNotifyManageRepo::class)->notifyRoles($notifyTarget, $notify);
        }

        return $notify;
    }

    /**
     * @param InformationNotify $notify
     * @param int $userId
     * @return InformationNotify
     */
    public function attachUser(InformationNotify $notify, int $userId)
    {
        $user = app(UserRepo::class)->find($userId);
        if (!is_null($user)) {
            return app(InformationNotifyManageRepo::class)->notifyPersonal($user, $notify);
        }

        return $notify;
    }

    /**
     * 新增訊息
     * @param int $categoryId
     * @param string $subject
     * @param string $content
     * @return InformationNotify|null
     */
    public function create(int $categoryId, string $subject, string $content)
    {
        $data = [
            'category_id' => $categoryId,
            'subject'     => $subject,
            'content'     => $content,
        ];
        $informationRepo = app(InformationNotifyManageRepo::class);
        $result = $informationRepo->create($data);

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
