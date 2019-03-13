<?php

Route::group(['middleware' => ['auth'], 'prefix' => '/admin'], function(){
    Route::get('/', 'AdminController@index')->name('admin.home');

    Route::get('transfer', 'BalanceController@transfer')->name('admin.transfer');
    Route::post('transfer', 'BalanceController@confirmTransfer')->name('transfer.store');
    Route::post('transfer/confirm', 'BalanceController@storeTransfer')->name('transfer.confirm');

    Route::get('withdraw', 'BalanceController@withdraw')->name('admin.withdraw');
    Route::post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');

    Route::get('/balance', 'BalanceController@index')->name('admin.balance');
    Route::get('/balance/deposit', 'BalanceController@deposit')->name('admin.deposit-balance');
    Route::post('/balance/deposit', 'BalanceController@store')->name('deposit.store');

    Route::any('transaction/search', 'TransactionController@search')->name('transaction.search');
    Route::get('transaction', 'TransactionController@index')->name('transaction.index');
});

Route::get('/', 'SiteController@index')->name('home');

Auth::routes();
