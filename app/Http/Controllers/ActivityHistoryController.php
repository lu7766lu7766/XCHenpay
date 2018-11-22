<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2018/11/19
 * Time: 下午 01:23
 */

namespace App\Http\Controllers;

use App\Http\Requests\ActivityHistoryRequest;
use App\Service\ActivityHistoryService;
use Cartalyst\Sentinel\Permissions\PermissionsInterface;
use Cartalyst\Sentinel\Users\UserInterface;

class ActivityHistoryController extends Controller
{
    /**
     * 帳戶歷程的index view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('admin.activity_log');
    }

    /**
     * @param ActivityHistoryRequest $request
     * @return array
     */
    public function data(ActivityHistoryRequest $request)
    {
        /** @var PermissionsInterface|UserInterface $user */
        $user = \Sentinel::getUser();
        $userId = null;
        if (!$user->hasAccess('activity_log')) {
            $userId = $user->getUserId();
        }

        return ActivityHistoryService::getInstance()->getRecords($request, $userId);
    }

    /**
     * @param ActivityHistoryRequest $request
     * @return int
     */
    public function total(ActivityHistoryRequest $request)
    {
        /** @var PermissionsInterface|UserInterface $user */
        $user = \Sentinel::getUser();
        $userId = null;
        if (!$user->hasAccess('activity_log')) {
            $userId = $user->getUserId();
        }

        return ActivityHistoryService::getInstance()->getRecordsTotal($request, $userId);
    }
}
