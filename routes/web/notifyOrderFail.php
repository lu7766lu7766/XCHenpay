<?php
/**
 * 回調錯誤記錄
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/27
 * Time: 下午 02:43
 */
Route::group([
    'prefix'     => 'admin/notifyOrderFail',
    'middleware' => ['admin', 'has:management,NotifyOrderFailPolicy'],
    'namespace'  => 'Admin',
    'as'         => 'admin.order.fail.'
], function () {
    Route::get('/', 'NotifyOrderFailController@indexView')->name('view');
    Route::group(['middleware' => 'json_api'], function () {
        Route::post('/', 'NotifyOrderFailController@index')->name('index');
        Route::post('/total', 'NotifyOrderFailController@total')->name('total');
    });
});
