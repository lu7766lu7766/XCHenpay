<?php
/**
 * 帳戶設置
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/18
 * Time: 下午 01:47
 */
Route::group(
    [
        'prefix'     => 'user/cashier/personal',
        'as'         => 'user.cashier.personal.',
        'namespace'  => 'User\Cashier',
        'middleware' => ['admin', 'has:management,PersonalAccountPolicy'],
    ],
    function () {
        Route::get('/', 'PersonalAccountController@indexView')->name('view');
        Route::group(['middleware' => ['json_api']], function () {
            Route::post('/', 'PersonalAccountController@index')->name('index');
            Route::post('total', 'PersonalAccountController@total')->name('total');
            Route::get('status', 'PersonalAccountController@status')->name('status');
            Route::get('{id}/info', 'PersonalAccountController@info')->name('info');
            Route::get('/channel', 'PersonalAccountController@channel')->name('channel');
            Route::post('create', 'PersonalAccountController@create')->name('create');
            Route::put('/', 'PersonalAccountController@update')->name('update');
        });
    }
);
