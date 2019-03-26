<?php
/**
 * 補單管理
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/26
 * Time: 上午 11:49
 */

use App\Policies\FillOrderPolicy;

Route::group(
    [
        'prefix'     => 'admin/order/fill',
        'middleware' => ['admin', 'has:management,' . FillOrderPolicy::class],
        'as'         => 'admin.fill_order.'
    ],
    function () {
        Route::get('/view', 'FillOrderController@view')->name('view');
        Route::group(['middleware' => ['json_api']], function () {
            Route::get('info/{id}', 'FillOrderController@info')->name('info');
            Route::post('index', 'FillOrderController@index')->name('index');
            Route::post('total', 'FillOrderController@total')->name('total');
            Route::post('edit', 'FillOrderController@edit')->name('edit');
            Route::get('options', 'FillOrderController@options')->name('options');
        });
    }
);
