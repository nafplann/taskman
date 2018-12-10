<?php

Route::get('/', 'DashboardController@index');

Route::group(['prefix' => 'auth'], function() {
    Route::get('login', 'SessionController@create')->name('login');
    Route::get('logout', 'SessionController@destroy');
    Route::post('login', 'SessionController@store');
    
    Route::get('register', 'RegistrationController@create');
    Route::post('register', 'RegistrationController@store');

    Route::get('reset', 'ResetPasswordController@create');
    Route::get('reset/{token}', 'ResetPasswordController@create')->name('password.reset');
    Route::post('reset', 'ForgotPasswordController@store')->name('password.email');
});

Route::group(['prefix' => 'projects'], function() {
    Route::get('/', 'ProjectController@index');
    Route::get('create', 'ProjectController@create');
    Route::get('invite', 'ProjectController@invite');
    Route::get('show/{id}', 'ProjectController@show');
    Route::post('create', 'ProjectController@store');
    Route::post('invite', 'ProjectController@sendInvitation');
});

Route::group(['prefix' => 'tasks'], function() {
    Route::get('get', 'TaskController@get');
    Route::post('create', 'TaskController@store');
});

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

Route::get('/test', function() {
    $when = now()->addMinutes(10);

    Mail::to(auth()->user())
        ->send(new SendMail);
});