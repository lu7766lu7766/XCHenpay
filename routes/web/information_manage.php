<?php
/**
 * 信息管理
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/25
 * Time: 下午 06:43
 */
Route::group(
    [
        'prefix'     => 'admin/informationManage/',
        'middleware' => ['admin', 'has:management,InformationManagePolicy'],
        'as'         => 'admin.information.publish.',
        'namespace'  => 'Manage'
    ],
    function () {
        Route::get('/', 'InformationManageController@view')->name('view');
        Route::group(['middleware' => 'json_api'], function () {
            Route::post('/', 'InformationManageController@index')->name('index');
            Route::post('/total', 'InformationManageController@total')->name('total');
            Route::get('roles', 'InformationManageController@role')->name('roles');
            Route::get('category', 'InformationManageController@category')->name('category');
            Route::get('{id}/info', 'InformationManageController@info')->name('info');
            Route::post('/notify', 'InformationManageController@create')->name('create');
            Route::delete('/', 'InformationManageController@delete')->name('delete');
        });
    }
);
