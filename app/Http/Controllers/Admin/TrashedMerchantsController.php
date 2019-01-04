<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrashedMerchant\TrashedMerchantsIndexRequest;
use App\Http\Requests\TrashedMerchant\TrashedMerchantsRestoreRequest;
use App\Service\TrashedMerchantsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class TrashedMerchantsController extends Controller
{
    /**
     * @param TrashedMerchantsIndexRequest $request
     * @return array
     */
    public function index(TrashedMerchantsIndexRequest $request)
    {
        return ['data' => TrashedMerchantsService::getInstance()->list($request)];
    }

    /**
     * @return Factory|View
     */
    public function indexView()
    {
        $user = [];

        // Show the page
        return view('admin.users.deleted_users', compact('users'));
    }

    /**
     * @param TrashedMerchantsRestoreRequest $request
     * @return array
     */
    public function restore(TrashedMerchantsRestoreRequest $request)
    {
        return ['data' => TrashedMerchantsService::getInstance()->restore($request)];
    }

    /**
     * @return array
     */
    public function total()
    {
        return ['total' => TrashedMerchantsService::getInstance()->total()];
    }
}
