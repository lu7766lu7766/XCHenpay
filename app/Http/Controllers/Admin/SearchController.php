<?php

namespace App\Http\Controllers\Admin;

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

    /**
     * 報表統計(版面)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportStatIndex()
    {
        return view('admin.search.reportStatRecord');
    }

    /**
     * 報表統計(資料)
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportStatQuery()
    {
        $service = SearchService::getInstance($this->getReq());

        return response()->json($service->reportStatQuery(request()->user()->company_service_id));
    }
}
