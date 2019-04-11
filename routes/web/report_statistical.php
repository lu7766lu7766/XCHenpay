<?php
/**
 * 報表統計
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/10
 * Time: 下午 06:07
 */
Route::group(
    [
        'prefix'     => 'admin',
        'namespace'  => 'User\Report',
        'middleware' => ['admin', 'has:management,ReportStatisticalPolicy'],
        'as'         => 'admin.',
    ],
    function () {
        Route::group(['prefix' => 'search'], function () {
            Route::get('reportStat/view', 'StatisticalController@view')
                ->name('search.reportStatIndex');
            Route::post('reportStatQuery', 'StatisticalController@index')
                ->name('search.reportStatQuery')
                ->middleware('json_api');
        });
    }
);
