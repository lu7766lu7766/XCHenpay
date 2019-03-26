<?php
/**
 * 商戶資料
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/26
 * Time: 下午 02:27
 */
Route::group([
    'prefix'     => 'admin/user',
    'namespace'  => 'Admin',
    'middleware' => ['admin'],
    'as'         => 'admin.user.'
], function () {
    Route::get('index', 'ProfileController@indexView')->name('view');
    Route::get('info', 'ProfileController@info')->middleware('json_api')->name('info');
    Route::put('profile/password', 'ProfileController@update')->name('update')
        ->middleware('json_api');
});
