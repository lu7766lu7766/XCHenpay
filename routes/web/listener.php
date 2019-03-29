<?php
/**
 * 監聽
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/29
 * Time: 下午 04:44
 */
Route::group([
    'prefix'     => 'listener',
    'namespace'  => 'Manage\Listener',
    'middleware' => ['admin', 'has:management,ListenerPolicy', 'json_api'],
], function () {
    Route::POST('/', 'ListenerController@order');
});
