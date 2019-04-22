<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/4/11
 * Time: 下午 03:21
 */
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
