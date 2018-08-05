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

Route::middleware('auth')->group(function () {
    Route::get('/', 'DashboardController@index')->name('home');
    Route::resource('user', 'UserController');

    /** Overtime */
    Route::resource('overtime', 'OvertimeController', ['only' => ['store']]);
    Route::put('overtime', 'OvertimeController@update')->name('overtime.update');

    /** user.overtime */
    Route::resource('user.overtime', 'OvertimeController', ['only' => ['index', 'updated']]);

    /** offtime */
    Route::resource('off_time', 'OffTimeController');

    /** payout */
    Route::resource('payout', 'PayoutController', ['only' => ['store', 'edit', 'update', 'create']]);
});

