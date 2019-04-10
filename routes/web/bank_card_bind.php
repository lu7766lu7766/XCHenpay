<?php
/**
 * 行卡綁定
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/9
 * Time: 下午 05:59
 */
#bank card bind 銀行卡綁定
Route::group([
    'prefix'     => 'user/bankCard/bind',
    'namespace'  => 'User',
    'middleware' => ['admin', 'has:management,BindBankCardPolicy'],
    'as'         => 'user.bankCard.bind.'
], function () {
    Route::get('/', 'BindBankCardController@indexView')->name('view');
    Route::group(['middleware' => 'json_api'], function () {
        Route::post('/', 'BindBankCardController@index')->name('index');
        Route::post('total', 'BindBankCardController@total')->name('total');
        Route::get('status', 'BindBankCardController@status')->name('status');
        Route::post('sendVerifyCode', 'BindBankCardController@sendVerifyCode')->name('sendVerifyCode');
        Route::post('info', 'BindBankCardController@info')->name('info');
        Route::post('binding', 'BindBankCardController@create')->name('create');
        Route::delete('/', 'BindBankCardController@delete')->name('delete');
    });
});
