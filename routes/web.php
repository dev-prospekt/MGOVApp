<?php

use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;


Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/test', function () {
        return view('sample');
    });

    // Logout
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    Route::resource('animal_units', AnimalUnitController::class);
    Route::resource('shelter', ShelterController::class);

    // Shelter Users
    Route::resource('users', ShelterUserController::class);
});
