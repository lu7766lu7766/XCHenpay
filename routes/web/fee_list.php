<?php
/**
 * 通道列表
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/27
 * Time: 上午 11:22
 */
Route::group([
    'prefix'     => 'admin/channel/feeList',
    'namespace'  => 'Admin',
    'middleware' => 'admin',
    'as'         => 'admin.channel.feeList.'
], function () {
    Route::get('/', 'FeeListController@indexView')->name('view')->middleware('has:management,FeeListPolicy');
    Route::group(['middleware' => ['json_api', 'has:management,FeeListPolicy']], function () {
        Route::get('/{id}', 'FeeListController@info')->name('info');
        Route::post('/', 'FeeListController@index')->name('index');
    });
});
