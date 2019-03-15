<?php
/**
 * 帳戶管理
 * Created by PhpStorm.
 * User: House
 * Date: 2019/3/15
 * Time: 下午 02:26
 */
Route::group(
    [
        'prefix'     => 'admin/cashier/manage',
        'as'         => 'admin.cashier.manage.',
        'namespace'  => 'Manage\Cashier',
        'middleware' => ['admin', 'has:management,BankCardAccountManagePolicy'],
    ],
    function () {
        Route::get('/', 'AccountManageController@indexView')->name('view');
        Route::group(['middleware' => ['json_api']], function () {
            Route::post('/', 'AccountManageController@index')->name('index');
            Route::post('total', 'AccountManageController@total')->name('total');
            Route::post('/info', 'AccountManageController@info')->name('info');
            Route::get('/merchant', 'AccountManageController@merchant')->name('merchant');
        });
    }
);
