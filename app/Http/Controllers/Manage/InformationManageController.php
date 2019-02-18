<?php

namespace App\Http\Controllers\Manage;

use App\Constants\Roles\RolesConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Information\Publish\InformationManageDeleteRequest;
use App\Http\Requests\Information\Publish\InformationManageIndexRequest;
use App\Http\Requests\Information\Publish\InformationManageInfoRequest;
use App\Http\Requests\Information\Publish\InformationManageStoreRequest;
use App\Http\Requests\Information\Publish\InformationManageTotalRequest;
use App\Models\InformationCategory;
use App\Models\InformationNotify;
use App\Service\InformationManageService;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class InformationPublishController
 * @package App\Http\Controllers\Admin
 */
class InformationManageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('admin.message_notify.messageManage');
    }

    /**
     * @return array
     */
    public function role()
    {
        return RolesConstants::enum();
    }

    /**
     * @param InformationManageIndexRequest $request
     * @return InformationNotify[]|Collection
     */
    public function index(InformationManageIndexRequest $request)
    {
        return InformationManageService::getInstance()->list($request);
    }

    /**
     * @param InformationManageTotalRequest $request
     * @return int
     */
    public function total(InformationManageTotalRequest $request)
    {
        return InformationManageService::getInstance()->total($request);
    }

    /**
     * @param InformationManageStoreRequest $request
     * @return array
     */
    public function create(InformationManageStoreRequest $request)
    {
        return ['data' => InformationManageService::getInstance()->notifyRole($request)];
    }

    /**
     * @param int $id
     * @return InformationNotify|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function info(int $id)
    {
        return InformationManageService::getInstance()->info(InformationManageInfoRequest::getHandle(['id' => $id]));
    }

    /**
     * @param InformationManageDeleteRequest $request
     * @return int
     */
    public function delete(InformationManageDeleteRequest $request)
    {
        return InformationManageService::getInstance()->delete($request);
    }

    /**
     * @return InformationCategory[]|Collection
     */
    public function category()
    {
        return InformationManageService::getInstance()->category();
    }
}
