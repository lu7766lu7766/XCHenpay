<?php
/**
 * header info
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/4/11
 * Time: 下午 02:10
 */
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
