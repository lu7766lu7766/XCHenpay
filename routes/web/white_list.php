<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2019/3/29
 * Time: 下午 03:07
 */

#whitelist
use App\Policies\WhiteListPolicy;

Route::group([
    'prefix'     => 'admin/whitelist',
    'namespace'  => 'Admin',
    'middleware' => ['admin', 'has:management,' . WhiteListPolicy::class],
    'as'         => 'admin.whitelist.'
], function () {
    Route::get('', 'WhitelistController@indexView')->name('view');
    Route::group(['middleware' => 'json_api'], function () {
        Route::post('/', 'WhitelistController@index')->name('index');
        Route::post('/total', 'WhitelistController@total')->name('total');
        Route::group(['prefix' => 'maintain'], function () {
            Route::get('/{id}', 'WhitelistController@info')->name('info');
            Route::post('/', 'WhitelistController@edit')->name('edit');
            Route::delete('/', 'WhitelistController@delete')->name('delete');
        });
    });
});
