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



Auth::routes(['verify' => true]);

Route::get('constructor', 'Page\HomeController@construction')->name('construction_route');

// Admin Dashboard Route
include_once('web-admin.php');

include_once('web-user.php');

include_once('web-www.php');