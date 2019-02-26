<?php

Route::group(['middleware' => ['auth'], 'prefix' => '/admin'], function(){
    Route::get('/', 'AdminController@index')->name('admin.home');
    Route::get('/balance/deposit', 'BalanceController@deposit')->name('admin.deposit-balance');
    Route::post('/balance/deposit', 'BalanceController@store')->name('deposit.store');
    Route::get('/balance', 'BalanceController@index')->name('admin.balance');
});

Route::get('/', 'SiteController@index')->name('home');

Auth::routes();
