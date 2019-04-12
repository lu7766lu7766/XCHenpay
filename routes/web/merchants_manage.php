<?php
/**
 * 商戶管理
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/11
 * Time: 下午 04:01
 */
Route::group(
    [
        'prefix'     => 'admin/merchants',
        'namespace'  => 'Admin',
        'middleware' => ['admin', 'has:view,MerchantsPolicy'],
        'as'         => 'admin.merchants.'
    ],
    function () {
        Route::get('/', 'MerchantsController@indexView')->name('view');
        Route::group(['middleware' => 'json_api'], function () {
            Route::post('/', 'MerchantsController@index')->name('index');
            Route::post('/total', 'MerchantsController@total')->name('total');
            Route::group(['prefix' => 'maintain'], function () {
                Route::put('/applyStatus', 'MerchantsController@updateApplyStatus')->name('applyStatus');
                Route::group(['middleware' => 'has:management,MerchantsPolicy'], function () {
                    Route::get('{id}', 'MerchantsController@info')->name('info');
                    Route::post('/', 'MerchantsController@create')->name('create');
                    Route::put('/', 'MerchantsController@update')->name('update');
                    Route::delete('/', 'MerchantsController@delete')->name('delete');
                });
            });
        });
    }
);
