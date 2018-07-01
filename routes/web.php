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
        Route::get('editProfile', 'UsersController@editProfile')->name('users.editProfile');
        Route::get('updateProfile', 'UsersController@updateProfile')->name('users.updateProfile');
        Route::get('{user}/delete', 'UsersController@destroy')->name('users.delete');
        Route::get('{user}/confirm-delete', 'UsersController@getModalDelete')->name('users.confirm-delete');
        Route::get('{user}/restore', 'UsersController@getRestore')->name('restore.user');
        Route::post('passwordreset', 'UsersController@passwordreset')->name('passwordreset');

        Route::post('sendVerifyCode', 'AccountController@sendVerifyCode')->name('account.sendVerifyCode');
        Route::post('addAccount', 'AccountController@verify')->name('account.addAccount');
    });
    Route::resource('users', 'UsersController');
    Route::get('deleted_users',['before' => 'Sentinel', 'uses' => 'UsersController@getDeletedUsers'])->name('users.deleted_users');

    Route::group([ 'prefix' => 'account'], function () {
        Route::get('{account}/confirm-delete', 'AccountController@getModalDelete')->name('account.confirm-delete');
        Route::get('{account}/delete', 'AccountController@destroy')->name('account.delete');
    });

    # Lock screen
    Route::get('{id}/lockscreen', 'UsersController@lockscreen')->name('lockscreen');
    Route::post('{id}/lockscreen', 'UsersController@postLockscreen')->name('post-lockscreen');
});
//Route::get('sendVerifyCode', 'Admin\AccountController@sendVerifyCode')->name('account.sendVerifyCode');
//
////Route::get('users/sendVerifyCode', 'Admin\AccountController@sendVerifyCode')->name('account.sendVerifyCode');
//
//
//Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => 'admin'], function () {
//    Route::group(['prefix' => 'users'], function () {
//        Route::get('sendVerifyCode', 'AccountController@sendVerifyCode')->name('account.sendVerifyCode');
//    });
//});

#tradeQuery  (index)
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    Route::get('logQuery', 'AuthcodeController@index')->name('authcode.index');
});

#lendApply
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => ['admin', 'lendApply'], 'as' => 'admin.'], function () {
    Route::get('lendApply', 'LendingController@index')->name('lendApply.index');
    Route::get('lendApply/data', 'LendingController@data')->name('lendApply.data');
    Route::post('lendApply/apply', 'LendingController@store')->name('lendApply.apply');
    Route::post('lendApply/getAccount', 'LendingController@getAccount')->name('lendApply.getAccount');
});

#lendManage
Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => ['admin', 'lendManage'], 'as' => 'admin.'], function () {
    Route::get('lendManage', 'LendManageController@index')->name('lendManage.index');
    Route::get('lendManage/data', 'LendManageController@data')->name('lendManage.data');
    Route::post('lendManage', 'LendManageController@store')->name('lendManage.store');
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



