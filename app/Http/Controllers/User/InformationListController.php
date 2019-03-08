<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Information\Lists\InformationListsDeleteRequest;
use App\Http\Requests\Information\Lists\InformationListsIndexRequest;
use App\Http\Requests\Information\Lists\InformationListsInfoRequest;
use App\Http\Requests\Information\Lists\InformationListsTotalRequest;
use App\Models\InformationCategory;
use App\Models\InformationNotify;
use App\Service\InformationListService;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class InformationListController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('admin.message_notify.messageList');
    }

    /**
     * @param InformationListsIndexRequest $request
     * @return InformationNotify[]|Collection
     */
    public function index(InformationListsIndexRequest $request)
    {
        return InformationListService::getInstance(\Sentinel::getUser())->list($request);
    }

    /**
     * @param InformationListsTotalRequest $request
     * @return int
     */
    public function total(InformationListsTotalRequest $request)
    {
        return InformationListService::getInstance(\Sentinel::getUser())->total($request);
    }

    /**
     * @param $id
     * @return InformationNotify|null
     * @throws ValidationException
     */
    public function info($id)
    {
        return InformationListService::getInstance(\Sentinel::getUser())->info(
            InformationListsInfoRequest::getHandle(['id' => $id])
        );
    }

    /**
     * @param InformationListsDeleteRequest $request
     * @return array
     */
    public function delete(InformationListsDeleteRequest $request)
    {
        return ['data' => InformationListService::getInstance(\Sentinel::getUser())->delete($request)];
    }

    /**
     * @return InformationCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function category()
    {
        return InformationListService::getInstance(\Sentinel::getUser())->category();
    }

    /**
     * @return int
     */
    public function unreadCount()
    {
        return InformationListService::getInstance(\Sentinel::getUser())->unreadCount();
    }
}
