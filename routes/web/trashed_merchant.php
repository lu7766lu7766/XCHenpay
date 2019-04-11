<?php
/**
 * 已刪除商戶列表
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/11
 * Time: 下午 03:27
 */
#刪除商戶列表
Route::group([
    'prefix'     => 'admin/trashedMerchants',
    'namespace'  => 'Admin',
    'as'         => 'trashed.merchants.',
    'middleware' => ['admin', 'has:management,TrashedMerchantsPolicy', 'json_api']
], function () {
    Route::post('/', 'TrashedMerchantsController@index')->name('index');
    Route::post('/total', 'TrashedMerchantsController@total')->name('total');
    Route::post('/restore', 'TrashedMerchantsController@restore')->name('restore');
});
