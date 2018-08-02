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
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('user', 'UserController');

    /** Overtime */
    Route::resource('overtime', 'OvertimeController', ['except' => ['update', 'show']]);
    Route::put('overtime', 'OvertimeController@update')->name('overtime.update');

    /** offtime */
    Route::resource('off_time', 'OffTimeController', ['only' => ['update', 'destroy', 'edit']]);

});

