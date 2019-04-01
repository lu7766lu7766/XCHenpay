<?php
/**
 * @todo file name 要明確, e.g. manage_order_listener.
 * 監聽
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 04:44
 */
Route::group([
    // @todo uri 要明確, e.g. manage/order/listener.
    'prefix'     => 'listener',
    'namespace'  => 'Manage\Listener',
    'middleware' => ['admin', 'has:management,ListenerPolicy', 'json_api'],
], function () {
    Route::POST('/', 'ListenerController@order');
});
