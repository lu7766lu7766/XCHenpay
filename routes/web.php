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
# Activity log
Route::group(
    [
        'prefix'     => 'admin',
        'middleware' => ['admin'],
        'as'         => 'admin.'
    ],
    function () {
        Route::get('activity_log', 'ActivityHistoryController@view')->name('activity_log');
        Route::group(['middleware' => ['json_api']], function () {
            Route::post('activity_log/data', 'ActivityHistoryController@data')->name('activity_log.data');
            Route::post('activity_log/data/total', 'ActivityHistoryController@total')->name('activity_log.data.total');
        });
    }
);
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
#刪除商戶列表
Route::group([
    'prefix'     => 'admin/trashedMerchants',
    'namespace'  => 'Admin',
    'as'         => 'trashed.merchants.',
    'middleware' => ['admin', 'has:management,TrashedMerchantsPolicy', 'json_api']
], function () {
    Route::post('/', 'TrashedMerchantsController@index')->name('index');
    Route::post('/total', 'TrashedMerchantsController@total')->name('total');
    Route::post('/restore', 'TrashedMerchantsController@restore')->name('restore');
});
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
#search
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin', 'search'], 'as' => 'admin.'],
    function () {
        Route::group(['prefix' => 'search'], function () {
            Route::get('report/view', 'SearchController@reportIndex')->name('search.reportIndex');
            Route::get('reportStat/view', 'SearchController@reportStatIndex')->name('search.reportStatIndex');
            Route::group(['middleware' => ['json_api']], function () {
                Route::post('reportQuery', 'SearchController@reportQuery')->name('search.reportQuery');
                Route::post('reportStatQuery', 'SearchController@reportStatQuery')->name('search.reportStatQuery');
            });
        });
    }
);
#paymentManage
Route::group([
    'prefix'     => 'admin/payment/manage',
    'namespace'  => 'Manage\Payment',
    'middleware' => ['admin', 'has:management,PaymentManagePolicy'],
    'as'         => 'admin.systemSetting.paymentManage.'
], function () {
    Route::get('', 'PaymentManageController@indexView')->name('view');
    Route::group(['middleware' => ['json_api']], function () {
        Route::post('dataList', 'PaymentManageController@dataList')->name('dataList');
        Route::post('dataTotal', 'PaymentManageController@dataTotal')->name('dataTotal');
        Route::post('detail', 'PaymentManageController@detail')->name('detail');
        Route::post('add', 'PaymentManageController@add')->name('add');
        Route::post('update', 'PaymentManageController@update')->name('update');
        Route::post('del', 'PaymentManageController@del')->name('del');
    });
});
#permission
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::get('permissionSwitch', 'PermissionController@permissionSwitch')->name('permission.switch');
    Route::post('permissionSwitch', 'PermissionController@update')->name('permission.update');
});
#headerInfo
Route::group(
    ['prefix' => 'admin', 'middleware' => ['admin', 'json_api']],
    function () {
        Route::group(['namespace' => 'Admin'], function () {
            Route::get('tradeInfoOnToday', 'AuthcodeController@tradeInfoOnToday');
            Route::get('pendingCount', 'BankCardListController@pendingCount')
                ->middleware('has:pendingCount,HeaderInfoPolicy');
        });
        Route::group(['namespace' => 'User'], function () {
            Route::get('unreadCount', 'InformationListController@unreadCount');
        });
    }
);
#frond end use
Route::group([
    'prefix'     => 'admin/description',
    'as'         => 'admin.description.',
    'namespace'  => 'FrondEnd',
    'middleware' => ['admin'],
], function () {
    Route::get('alipay', 'DescriptionController@alipay');
});
