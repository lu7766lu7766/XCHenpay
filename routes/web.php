<?php
Route::get('setlocale/{locale}', function ($locale) {
    if (in_array($locale, \Config::get('app.locales'))) {
        Session::put('locale', $locale);
        Session::put('fallback_locale', $locale);
    }

    return redirect()->back();
});
#home
Route::get('/', [
    'as'         => 'home',
    'middleware' => 'admin',
    function () {
        // Is the user logged in?
        if (Sentinel::check()) {
            return Redirect::route('admin.authcode.index');
        }

        // Show the page
        return view('admin.login');
    }
]);
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin'], 'as' => 'admin.'],
    function () {
        # Lock screen
        Route::get('{id}/lockscreen', 'UsersController@lockscreen')->name('lockscreen');
        Route::post('{id}/lockscreen', 'UsersController@postLockscreen')->name('post-lockscreen');
    }
);
#permission
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::get('permissionSwitch', 'PermissionController@permissionSwitch')->name('permission.switch');
    Route::post('permissionSwitch', 'PermissionController@update')->name('permission.update');
});
#frond end use
Route::group([
    'prefix'     => 'admin/description',
    'as'         => 'admin.description.',
    'namespace'  => 'FrondEnd',
    'middleware' => ['admin'],
], function () {
    Route::get('alipay', 'DescriptionController@alipay');
});
