<?php
/**
 * 行卡列表
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/9
 * Time: 下午 05:01
 */
#bankCard list
Route::group(
    [
        'prefix'     => 'admin',
        'namespace'  => 'Admin',
        'middleware' => ['admin', 'has:management,BankCardListPolicy'],
        'as'         => 'admin.bankCard.'
    ],
    function () {
        Route::group(['prefix' => 'bankCard'], function () {
            Route::get('/', 'BankCardListController@view')->name('view');
            Route::group(['middleware' => 'json_api'], function () {
                Route::get('getCompany', 'BankCardListController@getCompany')->name('getCompany');
                Route::get('status', 'BankCardListController@status')->name('status');
                Route::post('/', 'BankCardListController@index')->name('index');
                Route::post('total', 'BankCardListController@total')->name('total');
                Route::delete('/', 'BankCardListController@delete')->name('delete');
                Route::get('{id}', 'BankCardListController@info')->name('info');
                Route::put('/', 'BankCardListController@update')->name('update');
            });
        });
    }
);
