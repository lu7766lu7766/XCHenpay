<?php
/**
 * 通道管理
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/3/26
 * Time: 下午 04:11
 */
#feeManagement
Route::group([
    'prefix'     => 'admin/channel/feeManagement',
    'namespace'  => 'Admin',
    'middleware' => ['admin', 'has:management,FeeManagementPolicy'],
    'as'         => 'admin.channel.feeManagement.'
], function () {
    Route::get('/', 'FeeManagementController@indexView')->name('view');
    Route::group(['middleware' => 'json_api'], function () {
        Route::get('/merchantList', 'FeeManagementController@merchantList')->name('merchant.list');
        Route::post('/info', 'FeeManagementController@info')->name('info');
        Route::post('/', 'FeeManagementController@index')->name('index');
        Route::put('maintain/', 'FeeManagementController@edit')->name('edit');
    });
});
