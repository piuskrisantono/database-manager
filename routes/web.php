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






Route::put('/dbrequest/updatevip/{servicename}', 'DbrequestController@updateVip');
Route::put('/dbrequest/updatevmstatus/{servicename}', 'DbrequestController@updateVmStatus');
Route::get('/dbrequest', 'DbrequestController@index');
Route::get('/dbrequest/installed/monitor', function () {
    return view('db.monitoring');
});


Route::middleware(['auth', 'auth.dba'])->group(function () {
    Route::resource('/user', 'UserController');

    Route::get('/dbrequest/installed', 'DbrequestController@getInstalled');
    Route::post('/dbrequest/installed/authdb', 'DbrequestController@authDb');
    Route::post('/dbrequest/installed/modify-config', 'DbrequestController@modifyConfig');

    Route::get('/', 'DbrequestController@getInstalled');
    Route::get('/viewInstaller', 'DbrequestController@viewInstaller');
    Route::resource('/dbrequest', 'DbrequestController')->except(['index']);
    Route::put('/dbrequest/cancelrequestready/{servicename}', 'DbrequestController@cancelVmStatus');

    Route::post('/dbrequest/install', 'DbrequestController@runInstaller');

    Route::get('/adddatabase', function () {
        return view('db.addInstalled');
    });

    Route::post('/adddatabase', 'DbrequestController@addInstalled');
    Route::get('/updateInstalled/{servicename}', 'DbrequestController@editInstalled');
    Route::put('/updateInstalled/{servicename}', 'DbrequestController@updateInstalled');

    Route::get('/history', 'HistoryController@index')->middleware(['auth', 'auth.dba']);
});
