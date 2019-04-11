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
Route::pattern('slug', '[a-z0-9- _]+');
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
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin'], 'as' => 'admin.'],
    function () {
        # Lock screen
        Route::get('{id}/lockscreen', 'UsersController@lockscreen')->name('lockscreen');
        Route::post('{id}/lockscreen', 'UsersController@postLockscreen')->name('post-lockscreen');
    }
);
#商戶管理
Route::group(
    [
        'prefix'     => 'admin/merchants',
        'namespace'  => 'Admin',
        'middleware' => ['admin', 'has:view,MerchantsPolicy'],
        'as'         => 'admin.merchants.'
    ],
    function () {
        Route::get('/', 'MerchantsController@indexView')->name('view');
        Route::group(['middleware' => 'json_api'], function () {
            Route::post('/', 'MerchantsController@index')->name('index');
            Route::post('/total', 'MerchantsController@total')->name('total');
            Route::group(['prefix' => 'maintain'], function () {
                Route::put('/applyStatus', 'MerchantsController@updateApplyStatus')->name('applyStatus');
                Route::group(['middleware' => 'has:management,MerchantsPolicy'], function () {
                    Route::get('{id}', 'MerchantsController@info')->name('info');
                    Route::post('/', 'MerchantsController@create')->name('create');
                    Route::put('/', 'MerchantsController@update')->name('update');
                    Route::delete('/', 'MerchantsController@delete')->name('delete');
                });
            });
        });
    }
);
#tradeQuery  (index)
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin', 'as' => 'admin.'],
    function () {
        Route::group(['middleware' => 'tradeLog'], function () {
            Route::get('logQuery', 'AuthcodeController@index')->name('authcode.index');
            Route::get('logQuery/showInfo/{authcode}', 'AuthcodeController@showInfo')->name('authcode.showInfo');
            Route::get('logQuery/showState/{authcode}', 'AuthcodeController@showState')->name('authcode.showState');
            Route::post('logQuery/updateState', 'AuthcodeController@updateState')->name('authcode.stateUpdate');
            Route::get('logQuery/showFeeInfo/{payment}', 'AuthcodeController@showFeeInfo')
                ->name('authcode.showFeeInfo');
            Route::get('logQuery/editFeeInfo/{payment}', 'AuthcodeController@editFeeInfo')
                ->name('authcode.editFeeInfo');
            Route::post('logQuery/updateFeeInfo', 'AuthcodeController@updateFeeInfo')
                ->name('authcode.updateFeeInfo');
        });
        Route::group(['middleware' => 'json_api'], function () {
            Route::post('dataTotal', 'AuthcodeController@dataTotal')->name('authcode.dataTotal');
            Route::post('orderTradeInfo', 'AuthcodeController@orderTradeInfo');
            Route::get('{id}/bankCardAccountInfo', 'AuthcodeController@bankCardAccountInfo');
        });
        Route::get('logQuery/payment', 'AuthcodeController@payment')->middleware('json_api')->name('authcode.payment');
        Route::post('data', 'AuthcodeController@data')->name('authcode.data');
        Route::get('logQuery/dataInit', 'AuthcodeController@dataInit')->name('authcode.dataInit');
        Route::post('logQuery/callNotify', 'AuthcodeController@callNotify')->name('authcode.callNotify')
            ->middleware(['json_api']);
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
