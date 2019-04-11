<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/10
 * Time: 下午 06:08
 */

namespace App\Http\Controllers\User\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchReportStatQueryRequest;
use App\Service\StatisticalService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StatisticalController extends Controller
{
    /**
     * 報表統計(版面)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('admin.search.reportStatRecord');
    }

    /**
     * 報表統計(資料)
     * @param Request $request
     * @return \App\User[]|Collection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request)
    {
        return StatisticalService::getInstance(\Sentinel::getUser())
            ->list(SearchReportStatQueryRequest::getHandle($request->toArray()));
    }
}
