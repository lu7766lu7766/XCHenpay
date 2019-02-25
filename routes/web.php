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
#bankCard list
Route::group(
    [
        'prefix'     => 'admin',
        'namespace'  => 'Admin',
        'middleware' => ['admin', 'has:management,BankCardListPolicy'],
        'as'         => 'admin.bankCard.'
    ],
    function () {
        Route::group(['prefix' => 'bankCard'], function () {
            Route::get('/', 'BankCardListController@view')->name('view');
            Route::group(['middleware' => 'json_api'], function () {
                Route::get('getCompany', 'BankCardListController@getCompany')->name('getCompany');
                Route::get('status', 'BankCardListController@status')->name('status');
                Route::post('/', 'BankCardListController@index')->name('index');
                Route::post('total', 'BankCardListController@total')->name('total');
                Route::delete('/', 'BankCardListController@delete')->name('delete');
                Route::get('{id}', 'BankCardListController@info')->name('info');
                Route::put('/', 'BankCardListController@update')->name('update');
            });
        });
    }
);
#bank card bind 銀行卡綁定
Route::group([
    'prefix'     => 'user/bankCard/bind',
    'namespace'  => 'User',
    'middleware' => ['admin', 'has:management,BindBankCardPolicy'],
    'as'         => 'user.bankCard.bind.'
], function () {
    Route::get('/', 'BindBankCardController@indexView')->name('view');
    Route::group(['middleware' => 'json_api'], function () {
        Route::post('/', 'BindBankCardController@index')->name('index');
        Route::post('total', 'BindBankCardController@total')->name('total');
        Route::get('status', 'BindBankCardController@status')->name('status');
        Route::post('sendVerifyCode', 'BindBankCardController@sendVerifyCode')->name('sendVerifyCode');
        Route::post('info', 'BindBankCardController@info')->name('info');
        Route::post('binding', 'BindBankCardController@create')->name('create');
        Route::delete('/', 'BindBankCardController@delete')->name('delete');
    });
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
        });
        Route::get('logQuery/payment', 'AuthcodeController@payment')->middleware('json_api')->name('authcode.payment');
        Route::post('data', 'AuthcodeController@data')->name('authcode.data');
        Route::get('logQuery/dataInit', 'AuthcodeController@dataInit')->name('authcode.dataInit');
        Route::post('logQuery/callNotify', 'AuthcodeController@callNotify')->name('authcode.callNotify')
            ->middleware(['json_api']);
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
            Route::get('bankCardInfo', 'LendListController@bankCardInfo');
            Route::post('/', 'LendListController@index');
            Route::post('/apply', 'LendListController@apply');
            Route::post('/total', 'LendListController@total');
            Route::get('/{id}', 'LendListController@info');
        });
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
            Route::post('reportQuery', 'SearchController@reportQuery')->name('search.reportQuery');
            Route::get('reportStat/view', 'SearchController@reportStatIndex')->name('search.reportStatIndex');
            Route::post('reportStatQuery', 'SearchController@reportStatQuery')->name('search.reportStatQuery');
        });
    }
);
# systemSetting
Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin', 'system_setting'], 'as' => 'admin.'],
    function () {
        Route::get('systemSetting', 'SystemSettingController@index')
            ->name('systemSetting.accountManage');
        Route::group(['middleware' => 'json_api'], function () {
            Route::get('systemSetting/getRolesList', 'SystemSettingController@getRolesList')
                ->name('systemSetting.getRolesList');
            Route::post('systemSetting/userList', 'SystemSettingController@userList')
                ->name('systemSetting.userList');
            Route::post('systemSetting/userDetail', 'SystemSettingController@userDetail')
                ->name('systemSetting.userDetail');
            Route::post('systemSetting/userTotal', 'SystemSettingController@userTotal')
                ->name('systemSetting.userTotal');
            Route::post('systemSetting/userAdd', 'SystemSettingController@userAdd')
                ->name('systemSetting.userAdd');
            Route::post('systemSetting/userUpdate', 'SystemSettingController@userUpdate')
                ->name('systemSetting.userUpdate');
            Route::post('systemSetting/userDel', 'SystemSettingController@userDel')->name('systemSetting.userDel');
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
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin', 'json_api'], 'as' => 'admin.'],
    function () {
        Route::get('tradeInfoOnToday', 'AuthcodeController@tradeInfoOnToday');
        Route::get('pendingCount', 'BankCardListController@pendingCount')
            ->middleware('has:pendingCount,HeaderInfoPolicy');
    }
);
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
#notifyOrderFail
Route::group([
    'prefix'     => 'admin/notifyOrderFail',
    'middleware' => ['admin', 'has:management,NotifyOrderFailPolicy'],
    'namespace'  => 'Admin',
    'as'         => 'admin.order.fail.'
], function () {
    Route::get('/', 'NotifyOrderFailController@indexView')->name('view');
    Route::group(['middleware' => 'json_api'], function () {
        Route::post('/', 'NotifyOrderFailController@index')->name('index');
        Route::post('/total', 'NotifyOrderFailController@total')->name('total');
    });
});
#feeList
Route::group([
    'prefix'     => 'admin/channel/feeList',
    'namespace'  => 'Admin',
    'middleware' => 'admin',
    'as'         => 'admin.channel.feeList.'
], function () {
    Route::get('/', 'FeeListController@indexView')->name('view')->middleware('has:management,FeeListPolicy');
    Route::group(['middleware' => ['json_api', 'has:management,FeeListPolicy']], function () {
        Route::get('/{id}', 'FeeListController@info')->name('info');
        Route::post('/', 'FeeListController@index')->name('index');
    });
});
#feeManagement
Route::group([
    'prefix'     => 'admin/channel/feeManagement',
    'namespace'  => 'Admin',
    'middleware' => ['admin', 'has:management,FeeManagementPolicy'],
    'as'         => 'admin.channel.feeManagement.'
], function () {
    Route::get('/', 'FeeManagementController@indexView')->name('view');
    Route::group(['middleware' => 'json_api'], function () {
        Route::get('/merchantList', 'FeeManagementController@merchantList')->name('merchant.list');
        Route::post('/info', 'FeeManagementController@info')->name('info');
        Route::post('/', 'FeeManagementController@index')->name('index');
        Route::put('maintain/', 'FeeManagementController@edit')->name('edit');
    });
});
#user info 商戶資料
Route::group([
    'prefix'     => 'admin/user',
    'namespace'  => 'Admin',
    'middleware' => ['admin'],
    'as'         => 'admin.user.'
], function () {
    Route::get('index', 'ProfileController@indexView')->name('view');
    Route::get('info', 'ProfileController@info')->middleware('json_api')->name('info');
    Route::put('profile/password', 'ProfileController@update')->name('update')
        ->middleware('json_api');
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
#Information Manage
Route::group(
    [
        'prefix'     => 'admin/informationManage/',
        'middleware' => ['admin', 'has:management,InformationManagePolicy'],
        'as'         => 'admin.information.publish.',
        'namespace'  => 'Manage'
    ],
    function () {
        Route::get('/', 'InformationManageController@view')->name('view');
        Route::group(['middleware' => 'json_api'], function () {
            Route::post('/', 'InformationManageController@index')->name('index');
            Route::post('/total', 'InformationManageController@total')->name('total');
            Route::get('roles', 'InformationManageController@role')->name('roles');
            Route::get('category', 'InformationManageController@category')->name('category');
            Route::get('{id}/info', 'InformationManageController@info')->name('info');
            Route::post('/notify', 'InformationManageController@create')->name('create');
            Route::delete('/', 'InformationManageController@delete')->name('delete');
        });
    }
);
#informationLists
Route::group(
    [
        'prefix'     => 'user/informationLists',
        'as'         => 'user.information.list.',
        'namespace'  => 'User',
        'middleware' => 'has:management,InformationListsPolicy'
    ],
    function () {
        Route::get('/', 'InformationListController@view')->name('view');
        Route::group(['middleware' => 'json_api'], function () {
            Route::post('/', 'InformationListController@index')->name('index');
            Route::get('category', 'InformationListController@category')->name('category');
            Route::post('/total', 'InformationListController@total')->name('total');
            Route::get('{id}/info', 'InformationListController@info')->name('info');
            Route::delete('/', 'InformationListController@delete')->name('delete');
        });
    }
);
#公司帳戶
Route::group(
    [
        'prefix'     => 'admin/cashier/company',
        'as'         => 'admin.cashier.company.',
        'namespace'  => 'Manage\Cashier',
        'middleware' => ['admin', 'has:management,CompanyAccountPolicy'],
    ],
    function () {
        Route::get('/', 'CompanyAccountController@indexView')->name('view');
        Route::group(['middleware' => ['json_api']], function () {
            Route::post('/', 'CompanyAccountController@index')->name('index');
            Route::post('total', 'CompanyAccountController@total')->name('total');
            Route::get('{id}/info', 'CompanyAccountController@info')->name('info');
            Route::get('/channel', 'CompanyAccountController@channel')->name('channel');
            Route::post('create', 'CompanyAccountController@create')->name('create');
            Route::put('/', 'CompanyAccountController@update')->name('update');
        });
    }
);
Route::group(
    ['prefix' => 'pay/gateway/to_bank_card', 'namespace' => 'BankCardGateway'],
    function () {
        //todo funny#89
        Route::get('/', 'GatewayController@indexView');
        Route::get('data', 'GatewayController@index')->middleware('json_api');
    }
);
#cashier personal
#帳戶設置
Route::group(
    [
        'prefix'     => 'user/cashier/personal',
        'as'         => 'user.cashier.personal.',
        'namespace'  => 'User\Cashier',
        'middleware' => ['admin', 'has:management,PersonalAccountPolicy'],
    ],
    function () {
        Route::get('/', 'PersonalAccountController@indexView')->name('view');
        Route::group(['middleware' => ['json_api']], function () {
            Route::post('/', 'PersonalAccountController@index')->name('index');
            Route::post('total', 'PersonalAccountController@total')->name('total');
            Route::get('{id}/info', 'PersonalAccountController@info')->name('info');
            Route::get('/channel', 'PersonalAccountController@channel')->name('channel');
            Route::post('create', 'PersonalAccountController@create')->name('create');
            Route::put('/', 'PersonalAccountController@update')->name('update');
        });
    }
);
#帳戶管理
Route::group(
    [
        'prefix'     => 'admin/cashier/manage',
        'as'         => 'admin.cashier.manage.',
        'namespace'  => 'Manage\Cashier',
        'middleware' => ['admin', 'has:management,BankCardAccountManagePolicy'],
    ],
    function () {
        Route::get('/', 'AccountManageController@indexView')->name('view');
        Route::group(['middleware' => ['json_api']], function () {
            Route::get('/merchant', 'AccountManageController@merchant')->name('merchant');
            Route::post('/', 'AccountManageController@index')->name('index');
            Route::post('total', 'AccountManageController@total')->name('total');
            Route::post('/info', 'AccountManageController@info')->name('info');
        });
    }
);
