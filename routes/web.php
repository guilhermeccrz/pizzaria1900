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

Route::get('login', 'Administrators\AuthController@login')->name('login');

Route::namespace('Administrators')->prefix('administrator')->name('administrator.')->group(function () {
    require base_path('/routes/admins/admin.php');
});
