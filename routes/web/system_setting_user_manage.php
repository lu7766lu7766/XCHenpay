<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2019/3/29
 * Time: 下午 06:17
 */

# system setting user manage
use App\Policies\UserManagePolicy;

Route::group(
    [
        'prefix'     => 'admin',
        'namespace'  => 'Manage',
        'middleware' => ['admin', 'has:management,' . UserManagePolicy::class],
        'as'         => 'admin.'
    ],
    function () {
        Route::get('systemSetting', 'UserManageController@index')
            ->name('systemSetting.accountManage');
        Route::group(['middleware' => 'json_api'], function () {
            Route::get('systemSetting/getRolesList', 'UserManageController@getRolesList')
                ->name('systemSetting.getRolesList');
            Route::post('systemSetting/userList', 'UserManageController@userList')
                ->name('systemSetting.userList');
            Route::post('systemSetting/userDetail', 'UserManageController@userDetail')
                ->name('systemSetting.userDetail');
            Route::post('systemSetting/userTotal', 'UserManageController@userTotal')
                ->name('systemSetting.userTotal');
            Route::post('systemSetting/userAdd', 'UserManageController@userAdd')
                ->name('systemSetting.userAdd');
            Route::post('systemSetting/userUpdate', 'UserManageController@userUpdate')
                ->name('systemSetting.userUpdate');
            Route::post('systemSetting/userDel', 'UserManageController@userDel')->name('systemSetting.userDel');
        });
    }
);
