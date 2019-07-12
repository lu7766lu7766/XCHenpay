<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/15
 * Time: 上午 11:00
 */
/**
 * 商戶訂單監聽
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 04:44
 */
Route::group([
    'prefix'     => 'user/order/listener',
    'namespace'  => 'User\Order',
    'middleware' => ['admin', 'has:userOrderListener,ListenerOrderPolicy', 'json_api', 'throttle:60,1'],
], function () {
    Route::POST('/', 'ListenerController@bankCardOrder');
    Route::POST('payment', 'ListenerController@orders');
    Route::POST('is_call_back', 'ListenerController@isCallBack');
});
