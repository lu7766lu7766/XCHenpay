<?php
/**
 * 訂單監聽
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 04:44
 */
Route::group([
    'prefix'     => 'manage/order/listener',
    'namespace'  => 'Manage\Order',
    'middleware' => ['admin', 'has:listenOrder,ListenerOrderPolicy', 'json_api', 'throttle:60,1'],
], function () {
    Route::POST('/', 'ListenerController@bankCardOrder');
    Route::POST('/payment', 'ListenerController@order');
    Route::POST('is_call_back', 'ListenerController@isCallBack');
});
