<?php
/**
 * 下發管理
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/10
 * Time: 下午 01:32
 */
#lendManage
Route::group(
    [
        'prefix'     => 'admin',
        'namespace'  => 'Admin',
        'middleware' => ['admin', 'has:management,LendManagePolicy'],
        'as'         => 'admin.'
    ],
    function () {
        Route::get('lendManage', 'LendManageController@index')->name('lendManage.index');
        Route::group(['middleware' => ['json_api']], function () {
            Route::get('lendManage/data', 'LendManageController@dataInit')->name('lendManage.dataInit');
            Route::post('lendManage/data', 'LendManageController@data')->name('lendManage.data');
            Route::post('lendManage/dataTotal', 'LendManageController@dataTotal')->name('lendManage.dataTotal');
            Route::post('lendManage/total', 'LendManageController@total')->name('lendManage.total');
            Route::post('lendManage', 'LendManageController@update')->name('lendManage.Manage');
            Route::get('lendManage/applyNotice', 'LendManageController@applyNotice')->name('lendManage.notice');
        });
    }
);
