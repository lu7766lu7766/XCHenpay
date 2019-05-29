<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/24
 * Time: 下午 03:15
 */
Route::group([
    'prefix'     => 'company/software/download',
    'namespace'  => 'Company\Software',
    'middleware' => ['admin'],
], function () {
    Route::get('/', 'DownloadController@index')->name('software.download');
    Route::get('/data', 'DownloadController@data')->middleware('json_api');
});
