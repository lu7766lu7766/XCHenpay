<?php
/**
 * 帳戶歷程
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/11
 * Time: 下午 03:59
 */
# Activity log
Route::group(
    [
        'prefix'     => 'admin',
        'middleware' => ['admin'],
        'as'         => 'admin.'
    ],
    function () {
        Route::get('activity_log', 'ActivityHistoryController@view')->name('activity_log');
        Route::group(['middleware' => ['json_api']], function () {
            Route::post('activity_log/data', 'ActivityHistoryController@data')->name('activity_log.data');
            Route::post('activity_log/data/total', 'ActivityHistoryController@total')->name('activity_log.data.total');
        });
    }
);
