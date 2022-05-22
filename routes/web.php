<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */

Route::group(['middleware' => ['web']], function () {
    //routes here
    Route::get('/', 'DashboardController@index');

    // Authorization
    Route::get('/login', ['as' => 'auth.login.form', 'uses' => 'Auth\SessionController@getLogin']);
    Route::post('/login', ['as' => 'auth.login.attempt', 'uses' => 'Auth\SessionController@postLogin']);
    Route::get('/logout', ['as' => 'auth.logout', 'uses' => 'Auth\SessionController@getLogout']);

    // Password Reset
    Route::get('password/reset/{code}', ['as' => 'auth.password.reset.form', 'uses' => 'Auth\PasswordController@getReset']);
    Route::post('password/reset/{code}', ['as' => 'auth.password.reset.attempt', 'uses' => 'Auth\PasswordController@postReset']);
    Route::get('password/reset', ['as' => 'auth.password.request.form', 'uses' => 'Auth\PasswordController@getRequest']);
    Route::post('password/reset', ['as' => 'auth.password.request.attempt', 'uses' => 'Auth\PasswordController@postRequest']);

    // Roles
    Route::resource('roles', 'RoleController');

    // Profile
    Route::get('user_profile', ['as' => 'update.profile', 'uses' => 'UserProfilesController@getProfile']);
    Route::post('user_profile', ['as' => 'store.profile', 'uses' => 'UserProfilesController@postProfile']);
    //dashboard
    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

    // Site Settings
    Route::get('settings', ['as' => 'settings.index', 'uses' => 'SettingsController@usersSettings']);
    Route::post('settingsStore', ['as' => 'settingsStore', 'uses' => 'SettingsController@usersSettingsStore']);
});

Route::group(['middleware' => ['web']], function () {
    Route::resource('users', 'UserController');
    Route::get('/users/activeDeactive/{id}', ['as' => 'users.activeDeactive', 'uses' => 'UserController@activeDeactive']);

    Route::resource('antajax', '\\AjaxController');
    Route::post('/antajax/states', ['as' => 'ajaxState', 'uses' => 'AjaxController@postStates']);

    Route::resource('currency', 'Currency\\CurrencyController');

    Route::resource('product', 'Product\\ProductController');

   
});



