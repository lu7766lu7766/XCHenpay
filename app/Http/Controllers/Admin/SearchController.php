<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AuthCodes;

class SearchController extends Controller
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
        $request = request();
        $report = app(AuthCodes::class)
            ->getReportRecord($request->startDate, $request->endDate);

        return response()->json(["code" => 200, "data" => $report]);
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
        $request = request();
        $report = app(AuthCodes::class)
            ->getReportRecord($request->startDate, $request->endDate, $request->user()->id);

        return response()->json(["code" => 200, "data" => $report]);
    }
}
