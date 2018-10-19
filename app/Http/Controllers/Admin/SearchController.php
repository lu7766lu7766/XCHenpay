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
            ->getReportRecord($request->startDate . ' 00:00:00', $request->endDate . ' 23:59:59');

        return response()->json(["code" => 200, "data" => $report]);
    }
}
