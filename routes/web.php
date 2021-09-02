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
use App\Http\Controllers\Shelter\ShelterController;


Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/test', function () {
        return view('sample');
    });

    // Logout
    Route::get('logout', [LoginController::class, 'logout']);

    Route::resource('shelter', Shelter\ShelterController::class);

    Route::get('shelter/{shelterId}/animal/{animalId}', [ShelterController::class, 'animalItems']);

    Route::resource('animal_item', Animal\AnimalItemController::class);
    Route::resource('animal', Animal\AnimalController::class);
    
    Route::resource('user', UserController::class);
});
