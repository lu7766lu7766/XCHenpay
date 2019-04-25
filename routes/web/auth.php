<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/4/23
 * Time: 下午 03:12
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    # Error pages should be shown without requiring login
    Route::get('404', function () {
        return view('errors/404');
    });
    Route::get('500', function () {
        return view('errors/500');
    });
    # All basic routes defined here
    Route::get('login', 'AuthController@getSignin')->name('login');
    Route::get('signin', 'AuthController@getSignin')->name('signin');
    Route::post('signin', 'AuthController@signIn')->name('postSignin');
    Route::post('signup', 'AuthController@postSignup')->name('admin.signup');
    Route::post('forgot-password', 'AuthController@postForgotPassword')->name('forgot-password');
    # Logout
    Route::get('logout', 'AuthController@getLogout')->name('logout');
    # Account Activation
    Route::get('activate/{userId}/{activationCode}', 'AuthController@getActivate')->name('activate');
});
