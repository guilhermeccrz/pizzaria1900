<?php
Route::get('auth', 'AuthController@login')->name('auth.login');
Route::post('auth/dologin', 'AuthController@doLogin')->name('auth.dologin');
Route::post('auth/resetpassword', 'AuthController@resetPassword')->name('auth.resetpassword');
Route::get('auth/{id}/redefpassword/{token}', 'AuthController@redefPassword')->name('auth.redefpassword');
Route::post('auth/doredefpassword', 'AuthController@doRedefPassword')->name('auth.doredefpassword');

Route::group(['middleware' => ['auth:administrator']], function () {
    Route::get('logout', 'AuthController@logout')->name('auth.logout');

    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

    Route::resource('user', 'UserController');
});
