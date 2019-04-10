<?php
/**
 * 下發申請
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/10
 * Time: 下午 01:19
 */
#lendList (下發列表)
Route::group(
    [
        'prefix'     => 'admin/lendList',
        'namespace'  => 'Admin',
        'middleware' => ['admin', 'has:management,LendListPolicy'],
        'as'         => 'admin.'
    ],
    function () {
        Route::get('/', 'LendListController@indexView')->name('lend.list.index');
        Route::group(['middleware' => 'json_api'], function () {
            Route::get('userInfo', 'LendListController@userInfo');
            Route::get('amountInfo', 'LendListController@amountInfo');
            Route::get('lendStatus', 'LendListController@lendStatus');
            Route::get('bankCardInfo', 'LendListController@bankCardInfo');
            Route::post('/', 'LendListController@index');
            Route::post('/apply', 'LendListController@apply');
            Route::post('/total', 'LendListController@total');
            Route::get('/{id}', 'LendListController@info');
        });
    }
);
