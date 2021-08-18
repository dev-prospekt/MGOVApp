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

    // Logout
    Route::get('logout', [LoginController::class, 'logout']);
});