<?php
/**
 * 報表查詢
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/10
 * Time: 下午 04:47
 */
#search
Route::group(
    [
        'prefix'     => 'admin',
        'namespace'  => 'Manage\Report',
        'middleware' => ['admin', 'has:management,ReportSearchPolicy'],
        'as'         => 'admin.',
    ],
    function () {
        Route::group(['prefix' => 'search'], function () {
            Route::get('report/view', 'SearchController@reportIndex')->name('search.reportIndex');
            Route::post('reportQuery', 'SearchController@reportQuery')
                ->name('search.reportQuery')
                ->middleware('json_api');
        });
    }
);
