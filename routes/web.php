<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Auth::routes();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('lang/{locale}', 'LocalController@setLocale');
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::get('/account/exportAccount', 'BankAccountController@exportAccount')->name('account.exportAccount');

    Route::post('/groups/{group}/user/{contact}', 'UserGroupController@store')->name('storeUserGroup');
    Route::post('/pay/{amount}/{currency}/{id}/{type}', 'PayController@pay')->name('pay');
    Route::post('/webhook/', 'PayController@webhook')->name('webhooks.mollie');
    Route::delete('/groups/{group}/user/{contact}', 'UserGroupController@destroy')->name('destroyUserGroup');
    Route::put('/settings', 'SettingsController@update')->name('settings.update');

    Route::post('/payrequest/', 'PayRequestController@store')->name('payrequest.store');
    Route::get('/payrequest/{id}', 'PayRequestController@pay')->name('payrequest');
    Route::resource('/contacts', 'ContactController');
    Route::resource('/account', 'BankAccountController');
    Route::resource('/groups', 'GroupController');
    Route::resource('/plannedpayments', 'PlannedPaymentController');

    Route::resource('/request', 'RequestController');
    Route::get('/ordersuccess/{type}/{id}', 'PayController@ordersuccess')->name('order.success');