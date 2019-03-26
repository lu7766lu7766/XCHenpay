<?php
/**
 * 支付通道
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/20
 * Time: 下午 03:02
 */
Route::group(
    ['prefix' => 'pay/gateway/', 'namespace' => 'BankCardGateway'],
    function () {
        Route::get('to_bank_card/', 'GatewayController@indexView');
        Route::get('to_bank_card/data', 'GatewayController@index')->middleware('json_api');
        Route::get('/', 'GatewayController@paymentView');
    }
);
