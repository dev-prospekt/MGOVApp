<?php


use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Auth;
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
    Route::get('logout', [LoginController::class, 'logout']);

    Route::resource('shelter', Shelter\ShelterController::class);

    Route::get('shelter/{shelterId}/animal/{code}', 'Shelter\ShelterController@animalItems');

    Route::resource('animal_item', Animal\AnimalItemController::class);

    Route::post('animal_item/changeShelter/{id}', 'Animal\AnimalItemController@changeShelter');
    Route::get('animal_item/getId/{id}', 'Animal\AnimalItemController@getId');

    Route::resource('animal', Animal\AnimalController::class);
    
    Route::resource('user', UserController::class);

    Route::get('users', 'UserController@index');
    Route::get('users-dt', 'UserController@indexDataTables')->name('users:dt');
    Route::get("restore/{user_id}", 'UserController@restore');
});
