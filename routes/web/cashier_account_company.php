<?php
/**
 * 公司帳戶
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/25
 * Time: 下午 12:09
 */
Route::group(
    [
        'prefix'     => 'admin/cashier/company',
        'as'         => 'admin.cashier.company.',
        'namespace'  => 'Manage\Cashier',
        'middleware' => ['admin', 'has:management,CompanyAccountPolicy'],
    ],
    function () {
        Route::get('/', 'CompanyAccountController@indexView')->name('view');
        Route::group(['middleware' => ['json_api']], function () {
            Route::post('/', 'CompanyAccountController@index')->name('index');
            Route::post('total', 'CompanyAccountController@total')->name('total');
            Route::get('{id}/info', 'CompanyAccountController@info')->name('info');
            Route::get('/channel', 'CompanyAccountController@channel')->name('channel');
            Route::post('create', 'CompanyAccountController@create')->name('create');
            Route::put('/', 'CompanyAccountController@update')->name('update');
            Route::get('status', 'CompanyAccountController@status')->name('status');
            Route::get('bank', 'CompanyAccountController@bank');
        });
    }
);
