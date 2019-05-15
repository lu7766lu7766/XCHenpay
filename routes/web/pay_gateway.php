<?php
/**
 * 支付通道
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/20
 * Time: 下午 03:02
 */
Route::group(
    ['prefix' => 'pay/gateway/'],
    function () {
        Route::group(['namespace' => 'BankCardGateway'], function () {
            Route::get('to_bank_card/', 'GatewayController@indexView')->name('pay.gateway.view');
            Route::get('to_bank_card/data', 'GatewayController@index')->middleware('json_api');
            Route::get('/', 'GatewayController@paymentView');
            Route::get('startup/select', 'StartUpController@selectView')->name('startup.select.view');
            Route::get('startup/taobo', 'StartUpController@taobo')->middleware('json_api')->name('startup.taoBo');
            Route::get('startup/aliPay', 'StartUpController@aliPay')->middleware('json_api')->name('startup.aliPay');
        });
        Route::group(['namespace' => 'Relay'], function () {
            Route::get('/relay', 'RelayController@view');
            Route::get('/relay/data', 'RelayController@data')->middleware('json_api');
        });
        Route::group(['namespace' => 'Order'], function () {
            Route::get('/extra/info', 'ExtraInfoController@add')->middleware('json_api');
        });
    }
);
