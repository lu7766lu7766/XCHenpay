<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Whitelist\WhitelistDeleteRequest;
use App\Http\Requests\Whitelist\WhitelistIndexRequest;
use App\Http\Requests\Whitelist\WhitelistInfoRequest;
use App\Http\Requests\Whitelist\WhitelistStoreRequest;
use App\Service\WhitelistService;
use Illuminate\Validation\ValidationException;

class WhitelistController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function indexView()
    {
        return view('admin.users.white_list');
    }

    /**
     * @param WhitelistIndexRequest $request
     * @return array
     */
    public function index(WhitelistIndexRequest $request)
    {
        return ['data' => WhitelistService::getInstance()->list($request)];
    }

    /**
     * @return array
     */
    public function total()
    {
        return ['data' => WhitelistService::getInstance()->total()];
    }

    /**
     * @param $id
     * @return array
     * @throws ValidationException
     */
    public function info($id)
    {
        return [
            'data' => WhitelistService::getInstance()->info(
                WhitelistInfoRequest::getHandle(['id' => $id])
            )
        ];
    }

    /**
     * @param WhitelistStoreRequest $request
     * @return array
     */
    public function edit(WhitelistStoreRequest $request)
    {
        return ['data' => WhitelistService::getInstance()->createOrUpdate($request)];
    }

    /**
     * @param WhitelistDeleteRequest $request
     * @return array
     */
    public function delete(WhitelistDeleteRequest $request)
    {
        return ['data' => WhitelistService::getInstance()->delete($request)];
    }
}
