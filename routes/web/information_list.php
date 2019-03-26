<?php
/**
 * 訊息列表
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/3/25
 * Time: 下午 03:56
 */
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
