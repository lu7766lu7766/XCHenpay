<?php
/**
 * 監聽設置
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/8
 * Time: 下午 02:29
 */
Route::group([
    'prefix'     => 'company/listener/setting',
    'namespace'  => 'Company\Listener\Setting',
    'middleware' => 'admin'
], function () {
    //view
    Route::group(['middleware' => 'has:bankTemplate,ListenerSettingPolicy'], function () {
        Route::get('/', 'BankTemplate@indexView')->name('admin.cashier.listener.setting');
        Route::get('/bank/template', 'BankTemplate@template');
    });
    Route::group([
        'prefix'     => 'bank/template',
        'middleware' => 'json_api'
    ], function () {
        //data
        Route::group(['middleware' => 'has:bankTemplate,ListenerSettingPolicy'], function () {
            Route::post('/', 'BankTemplate@index');
            Route::post('/total', 'BankTemplate@total');
            Route::post('/edit', 'BankTemplate@edit');
            Route::get('/{id}', 'BankTemplate@info');
            Route::get('/search/options', 'BankTemplate@options');
        });
        Route::post('/front', 'BankTemplate@front');
    });
});
