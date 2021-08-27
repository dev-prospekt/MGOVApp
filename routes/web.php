<?php


use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/test', function () {
        return view('sample');
    });


    Route::resource('shelter_units', Shelter\ShelterUnitController::class);
    Route::resource('animal_system_category', Animal\AnimalSystemCategoryController::class);
    Route::resource('animal_category', Animal\AnimalCategoryController::class);
    Route::resource('animal_item', Animal\AnimalItemController::class);
});
