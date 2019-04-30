<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/25
 * Time: 下午 05:36
 */
Route::group(
    [
        'prefix'     => 'user/payment/account/',
        'middleware' => ['admin']
    ],
    function () {
        Route::group(
            [
                'prefix'     => 'company/',
                'middleware' => ['has:company,UserPaymentAccountPolicy'],
                'namespace'  => 'Company'
            ],
            function () {
                Route::post('/info', 'UserPaymentAccountController@info')->middleware('json_api');
            }
        );
        Route::group(
            [
                'prefix'     => 'user/',
                'middleware' => ['has:user,UserPaymentAccountPolicy'],
                'namespace'  => 'User'
            ],
            function () {
                Route::post('/info', 'UserPaymentAccountController@info')->middleware('json_api');
            }
        );
    }
);
