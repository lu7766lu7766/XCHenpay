<?php

namespace App\Http\Controllers\Manage\Report;

use App\Http\Controllers\Admin\BaseController;
use App\Service\SearchService;

class SearchController extends BaseController
{
    /**
     * 報表查詢(版面)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportIndex()
    {
        return view('admin.search.reportRecord');
    }

    /**
     * 報表查詢(資料)
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportQuery()
    {
        $service = SearchService::getInstance($this->getReq());

        return response()->json($service->reportQuery());
    }
}
