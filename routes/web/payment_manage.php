<?php
/**
 * 金流管理
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/11
 * Time: 上午 11:30
 */
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
        Route::get('source', 'PaymentManageController@source')->name('source');
        Route::post('dataTotal', 'PaymentManageController@dataTotal')->name('dataTotal');
        Route::post('detail', 'PaymentManageController@detail')->name('detail');
        Route::post('add', 'PaymentManageController@add')->name('add');
        Route::post('update', 'PaymentManageController@update')->name('update');
        Route::post('del', 'PaymentManageController@del')->name('del');
    });
});
