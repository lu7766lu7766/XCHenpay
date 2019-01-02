<?php

use App\Policies\FillOrderPolicy;

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
Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    Route::get('activity_log', 'ActivityHistoryController@view')->name('activity_log');
    Route::post('activity_log/data', 'ActivityHistoryController@data')
        ->name('activity_log.data')->middleware('json_api');
    Route::post('activity_log/data/total', 'ActivityHistoryController@total')
        ->name('activity_log.data.total')->middleware('json_api');
});
# User Management
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin', 'users'], 'as' => 'admin.'],
    function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UsersController@index')
                ->name('users.index');
            Route::group(['middleware' => 'json_api'], function () {
                // @todo branch ed#14,請實作view, 新增商戶資料.
                // post filed 請參照 App\Http\Requests\UsersDataAddRequest::rules().
                Route::post('dataAdd', 'UsersController@dataAdd')
                    ->name('users.dataAdd');
                // @todo branch ed#14,請實作view, api 是下列uri中有data字段的route,一個是資料一個是資料總筆數.
                // post filed 請參照 App\Http\Requests\UsersDataRequest::rules().
                Route::post('data', 'UsersController@data')
                    ->name('users.data');
                Route::post('dataTotal', 'UsersController@dataTotal')
                    ->name('users.dataTotal');
                // @todo branch ed#14,請實作view, 商戶資料明細.
                // post filed 請參照 App\Http\Requests\UsersDataDetailRequest::rules().
                Route::post('dataDetail', 'UsersController@dataDetail')
                    ->name('users.dataDetail');
                // @todo branch ed#14,請實作view, 更新商戶資料.
                // post filed 請參照 App\Http\Requests\userDataUpdate::rules().
                Route::post('dataUpdate', 'UsersController@dataUpdate')
                    ->name('users.dataUpdate');
                // @todo branch ed#14,請實作view, 刪除商戶資料.
                // post filed 請參照 App\Http\Requests\UsersDataDelRequest::rules().
                Route::post('dataDel', 'UsersController@dataDel')
                    ->name('users.delete');
                // @todo branch ed#14,請實作view, 更新商戶下發狀態.
                // post filed 請參照 App\Http\Requests\applyStatusUpdate::rules().
                Route::post('applyStatusUpdate', 'UsersController@applyStatusUpdate')
                    ->name('users.applyStatusUpdate');
                // @todo branch ed#14,請實作view, 已刪除帳號列表.
                // post filed 請參照 App\Http\Requests\UsersDataTrashedRequest::rules().
                Route::post('dataTrashed', 'UsersController@dataTrashed')
                    ->name('users.dataTrashed');
                // @todo branch ed#14,請實作view, 已刪除帳號列表總筆數.
                Route::post('dataTrashedTotal', 'UsersController@dataTrashedTotal')
                    ->name('users.dataTrashedTotal');
                // @todo branch ed#14,請實作view, 還原已刪除帳號.
                // post filed 請參照 App\Http\Requests\userDataRestore::rules().
                Route::post('dataRestore', 'UsersController@dataRestore')
                    ->name('users.restore');
                // @todo branch ed#14,請實作view, 取得所有角色清單.
                Route::get('getRolesList', 'UsersController@getRolesList')
                    ->name('users.getRolesList');
                Route::get('getThisUser', 'UsersController@getThisUser')
                    ->name('users.getThisUser');
            });
            Route::get('showProfile', 'UsersController@showProfile')->name('users.showProfile');
            Route::post('passwordreset', 'UsersController@passwordreset')->name('passwordreset');
            Route::get('getUserInfo', 'UsersController@getUserInfo')->name('users.getUserInfo');
        });
        # Lock screen
        Route::get('{id}/lockscreen', 'UsersController@lockscreen')->name('lockscreen');
        Route::post('{id}/lockscreen', 'UsersController@postLockscreen')->name('post-lockscreen');
    }
);
#Account
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin', 'account'], 'as' => 'admin.'],
    function () {
        // @todo branch funny#11+12 請實作view, api
        Route::group(['prefix' => 'account'], function () {
            //view
            Route::get('/', 'AccountController@index')->name('account.index');
            Route::get('createAccount', 'AccountController@createAccount')->name('account.createAccount');
            //data
            Route::group(['middleware' => 'json_api'], function () {
                //no request.
                Route::get('getCompany', 'AccountController@getCompany')->name('account.getCompany');
                // post filed 請參照 App\Http\Requests\Account\GetAccountRequest::rules().
                Route::post('accountData', 'AccountController@accountData')->name('account.data');
                Route::post('total', 'AccountController@total')->name('account.total');
                //no request.
                Route::post('sendVerifyCode', 'AccountController@sendVerifyCode')->name('account.sendVerifyCode');
                // post filed 請參照 App\Http\Requests\Account\AddAccountRequest::rules().
                Route::post('addAccount', 'AccountController@addAccount')->name('account.addAccount');
                // post filed 請參照 App\Http\Requests\Account\DeleteAccountRequest::rules().
                Route::delete('deleteAccount', 'AccountController@deleteAccount')->name('account.delete');
                Route::delete('deleteAccountData', 'AccountController@deleteAccountData')
                    ->name('account.deleteAccountData');
                // post filed 請參照 App\Http\Requests\Account\GetAccountRequest::rules().
                Route::post('accountList', 'AccountController@accountList')->name('account.accountList');
                Route::post('listTotal', 'AccountController@listTotal')->name('account.listTotal');
            });
        });
    }
);
#tradeQuery  (index)
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin', 'tradeLog'], 'as' => 'admin.'],
    function () {
        Route::get('logQuery', 'AuthcodeController@index')->name('authcode.index');
        Route::get('logQuery/dataInit', 'AuthcodeController@dataInit')->name('authcode.dataInit');
        Route::post('data', 'AuthcodeController@data')->name('authcode.data');
        Route::get('logQuery/showInfo/{authcode}', 'AuthcodeController@showInfo')->name('authcode.showInfo');
        Route::get('logQuery/showState/{authcode}', 'AuthcodeController@showState')->name('authcode.showState');
        Route::post('logQuery/updateState', 'AuthcodeController@updateState')->name('authcode.stateUpdate');
        Route::post('logQuery/feeData', 'AuthcodeController@feeData')->name('authcode.feeData');
        Route::get('logQuery/showFeeInfo/{payment}', 'AuthcodeController@showFeeInfo')->name('authcode.showFeeInfo');
        Route::get('logQuery/editFeeInfo/{payment}', 'AuthcodeController@editFeeInfo')->name('authcode.editFeeInfo');
        Route::post('logQuery/updateFeeInfo', 'AuthcodeController@updateFeeInfo')->name('authcode.updateFeeInfo');
        Route::post('logQuery/callNotify', 'AuthcodeController@callNotify')->name('authcode.callNotify');
    }
);
#lendList (下發列表)
Route::group(
    ['prefix' => 'admin/lendList', 'namespace' => 'Admin', 'middleware' => ['admin', 'lendList'], 'as' => 'admin.'],
    function () {
        Route::get('/', 'LendListController@indexView')->name('lend.list.index');
        Route::group(['middleware' => 'json_api'], function () {
            Route::get('userInfo', 'LendListController@userInfo');
            Route::get('amountInfo', 'LendListController@amountInfo');
            Route::get('lendStatus', 'LendListController@lendStatus');
            Route::get('backAccountInfo', 'LendListController@backAccountInfo');
            Route::post('/', 'LendListController@index');
            Route::post('/apply', 'LendListController@apply');
            Route::post('/total', 'LendListController@total');
            Route::get('/{id}', 'LendListController@info');
            Route::post('sendVerifyCode', 'LendListController@sendVerifyCode');
        });
    }
);
#lendManage
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin', 'lendManage'], 'as' => 'admin.'],
    function () {
        // @todo branch ed#4,請實作view, api 可取得商戶下拉選單內容.
        Route::get('lendManage', 'LendManageController@index')
            ->name('lendManage.index');
        Route::group(['middleware' => ['json_api']], function () {
            Route::get('lendManage/data', 'LendManageController@dataInit')
                ->name('lendManage.dataInit');
            // @todo branch ed#4,請實作view, api 是下列uri中有data字段的route,一個是資料一個是資料總筆數.
            // post filed 請參照 App\Http\Requests\LendManageDataRequest::rules().
            Route::post('lendManage/data', 'LendManageController@data')
                ->name('lendManage.data');
            Route::post('lendManage/dataTotal', 'LendManageController@dataTotal')
                ->name('lendManage.dataTotal');
            // @todo branch ed#4,請實作view, 取得申請中金額.可提領金額與總計資訊.
            // post filed 請參照 App\Http\Requests\LendManageTotalRequest::rules().
            Route::post('lendManage/total', 'LendManageController@total')
                ->name('lendManage.total');
            // @todo branch ed#4,請實作view, api 變更下發申請單狀態.
            // post filed 請參照 App\Http\Requests\LendManageUpdateRequest::rules().
            Route::post('lendManage', 'LendManageController@update')
                ->name('lendManage.Manage');
            Route::get('lendManage/applyNotice', 'LendManageController@applyNotice')
                ->name('lendManage.notice');
        });
    }
);
#search
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin', 'search'], 'as' => 'admin.'],
    function () {
        Route::group(['prefix' => 'search'], function () {
            Route::get('report/view', 'SearchController@reportIndex')->name('search.reportIndex');
            Route::post('reportQuery', 'SearchController@reportQuery')->name('search.reportQuery');
            Route::get('reportStat/view', 'SearchController@reportStatIndex')->name('search.reportStatIndex');
            Route::post('reportStatQuery', 'SearchController@reportStatQuery')->name('search.reportStatQuery');
        });
    }
);
#permission
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::get('permissionSwitch', 'PermissionController@permissionSwitch')->name('permission.switch');
    Route::post('permissionSwitch', 'PermissionController@update')->name('permission.update');
});
#whitelist
Route::group([
    'prefix'     => 'admin/whitelist',
    'namespace'  => 'Admin',
    'middleware' => ['admin', 'whitelist'],
    'as'         => 'admin.whitelist.'
], function () {
    Route::get('', 'WhitelistController@indexView')->name('view');
    Route::group(['middleware' => 'json_api'], function () {
        Route::post('/total', 'WhitelistController@total')->name('total');
        Route::post('/', 'WhitelistController@index')->name('index');
        Route::group(['prefix' => 'maintain'], function () {
            Route::get('/{user_id}', 'WhitelistController@info')->name('info');
            Route::post('/', 'WhitelistController@edit')->name('edit');
            Route::delete('/', 'WhitelistController@delete')->name('delete');
        });
    });
});
#fill order
Route::group(
    [
        'prefix'     => 'admin/order/fill',
        'middleware' => ['admin', 'has:management,' . FillOrderPolicy::class],
        'as'         => 'admin.fill_order.'
    ],
    function () {
        Route::get('/view', 'FillOrderController@view')->name('view');
        Route::group(['middleware' => ['json_api']], function () {
            Route::get('info/{id}', 'FillOrderController@info')->name('info');
            Route::post('index', 'FillOrderController@index')->name('index');
            Route::post('total', 'FillOrderController@total')->name('total');
            Route::post('edit', 'FillOrderController@edit')->name('edit');
            Route::get('options', 'FillOrderController@options')->name('options');
        });
    }
);
