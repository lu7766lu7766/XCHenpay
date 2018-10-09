<?php
include_once 'web_builder.php';

Route::get('setlocale/{locale}', function ($locale) {
    if (in_array($locale, \Config::get('app.locales'))) {
        Session::put('locale', $locale);
        Session::put('fallback_locale', $locale);

    }
    return redirect()->back();
});

Route::pattern('slug', '[a-z0-9- _]+');

Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function () {

    # Error pages should be shown without requiring login
    Route::get('404', function () {
        return view('admin/404');
    });
    Route::get('500', function () {
        return view('admin/500');
    });

    # All basic routes defined here
    Route::get('login', 'AuthController@getSignin')->name('login');
    Route::get('signin', 'AuthController@getSignin')->name('signin');
    Route::post('signin', 'AuthController@postSignin')->name('postSignin');
    Route::post('signup', 'AuthController@postSignup')->name('admin.signup');
    Route::post('forgot-password', 'AuthController@postForgotPassword')->name('forgot-password');
    Route::get('login2', function () {
        return view('admin/login2');
    });

    # Logout
    Route::get('logout', 'AuthController@getLogout')->name('logout');

    # Account Activation
    Route::get('activate/{userId}/{activationCode}', 'AuthController@getActivate')->name('activate');
});

# Activity log
Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    Route::get('activity_log', 'JoshController@activityLog')->name('activity_log');
    Route::get('activity_log/data', 'JoshController@activityLogData')->name('activity_log.data');
});

# User Management
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => ['admin','users'], 'as' => 'admin.'], function () {
    Route::group([ 'prefix' => 'users'], function () {
        Route::get('data', 'UsersController@data')->name('users.data');
        Route::get('showProfile', 'UsersController@showProfile')->name('users.showProfile');
        Route::get('updateProfile', 'UsersController@updateProfile')->name('users.updateProfile');
        Route::get('{user}/delete', 'UsersController@destroy')->name('users.delete');
        Route::get('{user}/confirm-delete', 'UsersController@getModalDelete')->name('users.confirm-delete');
        Route::get('{user}/restore', 'UsersController@getRestore')->name('restore.user');
        Route::post('passwordreset', 'UsersController@passwordreset')->name('passwordreset');
        Route::get('getUserInfo', 'UsersController@getUserInfo')->name('users.getUserInfo');
        Route::get('{user}/showApplyStatus', 'UsersController@showApplyStatus')->name('users.showApplyStatus');
        Route::get('{user}/updateApplyStatus', 'UsersController@updateApplyStatus')->name('users.updateApplyStatus');

    });
    Route::resource('users', 'UsersController');
    Route::get('deleted_users',['before' => 'Sentinel', 'uses' => 'UsersController@getDeletedUsers'])->name('users.deleted_users');


    # Lock screen
    Route::get('{id}/lockscreen', 'UsersController@lockscreen')->name('lockscreen');
    Route::post('{id}/lockscreen', 'UsersController@postLockscreen')->name('post-lockscreen');
});

#Account
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => ['admin', 'account'], 'as' => 'admin.'], function () {
    Route::group([ 'prefix' => 'account'], function () {
        Route::get('/', 'AccountController@index')->name('account.index');
        Route::get('createAccount', 'AccountController@createAccount')->name('account.createAccount');
        Route::post('sendVerifyCode', 'AccountController@sendVerifyCode')->name('account.sendVerifyCode');
        Route::post('addAccount', 'AccountController@addAccount')->name('account.addAccount');
        Route::post('accountData', 'AccountController@accountData')->name('account.data');
        Route::get('{account}/confirm-delete', 'AccountController@getAccountDelete')->name('account.confirm-delete');
        Route::get('{account}/delete', 'AccountController@destroy')->name('account.delete');
    });
});


#tradeQuery  (index)
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => ['admin', 'tradeLog'], 'as' => 'admin.'], function () {
    Route::get('logQuery', 'AuthcodeController@index')->name('authcode.index');
    Route::post('data', 'AuthcodeController@data')->name('authcode.data');
    Route::get('logQuery/showInfo/{authcode}', 'AuthcodeController@showInfo')->name('authcode.showInfo');
    Route::get('logQuery/showState/{authcode}', 'AuthcodeController@showState')->name('authcode.showState');
    Route::post('logQuery/updateState', 'AuthcodeController@updateState')->name('authcode.stateUpdate');

    Route::post('logQuery/feeData', 'AuthcodeController@feeData')->name('authcode.feeData');
    Route::get('logQuery/showFeeInfo/{payment}', 'AuthcodeController@showFeeInfo')->name('authcode.showFeeInfo');
    Route::get('logQuery/editFeeInfo/{payment}', 'AuthcodeController@editFeeInfo')->name('authcode.editFeeInfo');
    Route::post('logQuery/updateFeeInfo', 'AuthcodeController@updateFeeInfo')->name('authcode.updateFeeInfo');
    Route::post('logQuery/callNotify', 'AuthcodeController@callNotify')->name('authcode.callNotify');
});

#lending
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => ['admin'], 'as' => 'admin.'], function () {
    Route::get('showLending', 'LendingController@index')->name('showLending.index');
    Route::post('showLending/getInfo', 'LendingController@getInfo')->name('showLending.getInfo');
    Route::get('showLending/getUserInfo', 'LendingController@getUserInfo')->name('showLending.getUserInfo');
    Route::post('showLending/apply', 'LendingController@apply')->name('showLending.apply');
    Route::post('showLending/data', 'LendingController@data')->name('showLending.data');
    Route::get('showLending/showRecord/{lendRecord}', 'LendingController@showRecordDialog')->name('showLending.showRecord');
});

#lendApply
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => ['admin', 'lendApply'], 'as' => 'admin.'], function () {
    Route::get('lendApply', 'LendApplyController@index')->name('lendApply.index');
    Route::post('lendApply/apply', 'LendApplyController@apply')->name('lendApply.apply');
    Route::post('lendApply/data', 'LendApplyController@data')->name('lendApply.data');
    Route::post('lendApply/getLendInfo', 'LendApplyController@getLendInfo')->name('lendApply.getLendInfo');
    Route::get('lendApply/showRecord/{lendRecord}', 'LendApplyController@showRecordDialog')->name('lendApply.showRecord');
});

#lendManage
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => ['admin', 'lendManage'], 'as' => 'admin.'], function () {
    Route::get('lendManage', 'LendManageController@index')->name('lendManage.index');
    Route::post('lendManage/getLendInfo', 'LendManageController@getLendInfo')->name('lendManage.getLendInfo');
    Route::post('lendManage/data', 'LendManageController@data')->name('lendManage.data');
    Route::get('lendManage/manageRecord/{lendRecord}', 'LendManageController@showManageDialog')->name('lendManage.manageRecord');
    Route::get('lendManage/showRecord/{lendRecord}', 'LendManageController@showRecordDialog')->name('lendManage.showRecord');
    Route::post('lendManage', 'LendManageController@update')->name('lendManage.Manage');
    Route::post('lendManage/total', 'LendManageController@total')->name('lendManage.total');
    Route::post('lendManage/applyingAndWithdrawalAmount', 'LendManageController@getApplyingAndWithdrawalAmount')->name('lendManage.applyingAndWithdrawalAmount');
});

#permission
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'as' => 'admin.'], function () {
    Route::get('permissionSwitch', 'PermissionController@permissionSwitch')->name('permission.switch');
    Route::post('permissionSwitch', 'PermissionController@update')->name('permission.update');
});

#home
Route::get('/', ['as' => 'home', 'middleware' => 'admin', function () {

    // Is the user logged in?
    if (Sentinel::check()) {
        return Redirect::route('admin.authcode.index');
    }

    // Show the page
    return view('admin.login');
}]);



