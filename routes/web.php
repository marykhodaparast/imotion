<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/login', 'UserController@login')->name('login');
Route::post('/login', 'UserController@login')->name('dologin');
Route::get('/register', 'RegisterController@index')->name('register');
Route::post('/register', 'RegisterController@sendsms')->name('sendsms');
Route::post('/register/checksms', 'RegisterController@checksms')->name('checksms');
Route::post('/register/createuser', 'RegisterController@createuser')->name('createuser');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard_admin');

    Route::group(['prefix' => '/athlete'], function () {
        Route::any('profile','AthleteController@profile')->name('athleteprofile');
        Route::any('dashboard','AthleteController@index')->name('athletedashboard');
        // Route::any('take_turn','AthleteController@takeTurn')->name('athletetaketurn');
    });
    Route::group(['prefix' => '/admin'], function(){
        Route::any('/','AdminController@dashboard')->name('admin_dashboard');
        Route::post('/ajax','AdminController@ajaxCall')->name('admin_ajax');
        Route::post('/save','AdminController@saveNewSlot')->name('admin_save_slot');
    });
});

