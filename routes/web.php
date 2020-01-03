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


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/dbrequest/installed', 'DbrequestController@getInstalled');
Route::post('/dbrequest/installed/authdb', 'DbrequestController@authDb');
Route::post('/dbrequest/installed/modify-config', 'DbrequestController@modifyConfig');



Route::get('/', 'DbrequestController@getInstalled')->middleware(['auth', 'auth.dba']);
Route::resource('/db', 'DbController')->middleware(['auth', 'auth.dba']);
Route::resource('/dbrequest', 'DbrequestController');
Route::put('/dbrequest/updatevip/{servicename}', 'DbrequestController@updateVip');
Route::put('/dbrequest/updatevmstatus/{servicename}', 'DbrequestController@updateVmStatus');
Route::put('/dbrequest/cancelrequestready/{servicename}', 'DbrequestController@cancelVmStatus');
Route::post('/dbrequest/install', 'DbrequestController@install');

Route::get('/history', 'HistoryController@index')->middleware(['auth', 'auth.dba']);


Route::post('/history', 'DbrequestController@install');


Route::namespace('DBA')->prefix('dba')->middleware(['auth', 'auth.dba'])->name('dba.')->group(function () {
    Route::resource('/user', 'UserController', ['except' => ['show', 'create', 'store']]);
});
