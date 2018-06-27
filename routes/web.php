<?php
include_once 'web_builder.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
    # Lock screen
    Route::get('{id}/lockscreen', 'UsersController@lockscreen')->name('lockscreen');
    Route::post('{id}/lockscreen', 'UsersController@postLockscreen')->name('lockscreen');
    # All basic routes defined here
    Route::get('login', 'AuthController@getSignin')->name('login');
    Route::get('signin', 'AuthController@getSignin')->name('signin');
    Route::post('signin', 'AuthController@postSignin')->name('postSignin');
    Route::post('signup', 'AuthController@postSignup')->name('admin.signup');
    Route::post('forgot-password', 'AuthController@postForgotPassword')->name('forgot-password');
    Route::get('login2', function () {
        return view('admin/login2');
    });


    # Register2
    Route::get('register2', function () {
        return view('admin/register2');
    });
    Route::post('register2', 'AuthController@postRegister2')->name('register2');

    # Forgot Password Confirmation
    Route::get('forgot-password/{userId}/{passwordResetCode}', 'AuthController@getForgotPasswordConfirm')->name('forgot-password-confirm');
    Route::post('forgot-password/{userId}/{passwordResetCode}', 'AuthController@getForgotPasswordConfirm');

    # Logout
    Route::get('logout', 'AuthController@getLogout')->name('logout');

    # Account Activation
    Route::get('activate/{userId}/{activationCode}', 'AuthController@getActivate')->name('activate');
});


Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    # GUI Crud Generator
    Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('generator_builder');
    Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');
    Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');
    // Model checking
    Route::post('modelCheck', 'ModelcheckController@modelCheck');

    # Dashboard / Index
    Route::get('/', 'JoshController@showHome')->name('dashboard');


    # Activity log
    Route::get('activity_log/data', 'JoshController@activityLogData')->name('activity_log.data');
//    Route::get('/', 'JoshController@index')->name('index');
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
});



Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {

    # Company Management
    Route::group([ 'prefix' => 'companies'], function () {
        Route::get('data', 'CompanyController@data')->name('companies.data');
        Route::get('{company}/delete', 'CompanyController@destroy')->name('companies.delete');
        Route::get('{company}/confirm-delete', 'CompanyController@getModalDelete')->name('companies.confirm-delete');
        Route::get('{company}/restore', 'CompanyController@getRestore')->name('restore.company');
        Route::post('{company}/passwordreset', 'CompanyController@passwordreset')->name('company.passwordreset');
    });
    Route::resource('companies', 'CompanyController');
//    Route::get('deleted_companies',['before' => 'Sentinel', 'companies' => 'CompanyController@getDeletedCompanies'])->name('deleted_companies');
    Route::get('deleted_companies','CompanyController@getDeletedCompanies')->name('deleted_companies');

    //tasks section
    Route::post('task/create', 'TaskController@store')->name('store');
    Route::get('task/data', 'TaskController@data')->name('data');
    Route::post('task/{task}/edit', 'TaskController@update')->name('update');
    Route::post('task/{task}/delete', 'TaskController@delete')->name('delete');


    Route::get('logQuery', 'AuthcodeController@index')->name('authcode.index');

    Route::get('lendApply', 'LendingController@index')->name('lendApply.index');
    Route::get('lendApply/data', 'LendingController@data')->name('lendApply.data');
    //Route::post('lendApply/store', 'LendingController@store')->name('lendApply.store');
    Route::post('lendApply/update', 'LendingController@update')->name('lendApply.update');
    Route::post('lendApply/delete', 'LendingController@destroy')->name('lendApply.delete');
    Route::post('lendApply/sendVerifyCode', 'LendingController@sendVerifyCode')->name('lendApply.sendCode');
    Route::post('lendApply/verify', 'LendingController@verify')->name('lendApply.verify');
    Route::get('lendApply/verify', 'LendingController@verify')->name('lendApply.verify');

    Route::get('lendManage', 'LendManageController@index')->name('lendManage.index');
    Route::post('lendManage/data', 'LendManageController@data')->name('lendManage.data');
    Route::post('lendManage', 'LendManageController@store')->name('lendManage.store');
});



# Remaining pages will be called from below controller method
# in real world scenario, you may be required to define all routes manually

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('{name?}', 'JoshController@showView');
});

#frontend views
Route::get('/', ['as' => 'home', 'middleware' => 'admin', function () {
//    return view('index');

    // Is the user logged in?
    if (Sentinel::check()) {
        return Redirect::route('admin.dashboard');
    }

    // Show the page
    return view('admin.login');
}]);



