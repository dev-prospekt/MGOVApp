<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Shelter\ShelterController;
use App\Http\Controllers\Animal\AnimalImportController;
use App\Http\Controllers\Animal\AnimalCategoryController;
use App\Http\Controllers\Animal\AnimalSeizedTypeController;
use App\Http\Controllers\Animal\AnimalSizeController;
use App\Http\Controllers\Animal\AnimalInvaziveTypeController;
use App\Http\Controllers\Animal\AnimalProtectedTypeController;
use App\Http\Controllers\Animal\AnimalOrderController;


Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/test', function () {
        return view('sample');
    });

    // Logout
    Route::get('logout', [LoginController::class, 'logout']);

    Route::resource('shelter', Shelter\ShelterController::class);
    Route::resource('animal_item', Animal\AnimalItemController::class);
    Route::resource('animal', Animal\AnimalController::class);
    Route::resource('animal_category', Animal\AnimalCategoryController::class);
    Route::resource('user', UserController::class);
    Route::resource('animal_size', Animal\AnimalSizeController::class);
    Route::get('get_animal_size', [AnimalSizeController::class, 'getSizes'])->name('get_animal_size');
    Route::resource('animal_order', Animal\AnimalOrderController::class);


    Route::get('shelter/{shelterId}/animal/{animalId}', [ShelterController::class, 'animalItems']);
    // Strogo zaštićene
    Route::get('/sz_animal_type', [AnimalProtectedTypeController::class, 'getSZAnimalTypes'])->name('sz_animal_type');
    Route::get('/sz_animal_type/create', [AnimalProtectedTypeController::class, 'createSZAnimalTypes'])->name('create_sz_animal_type');
    Route::post('/sz_animal_type/category', [AnimalCategoryController::class, 'store'])->name('create_sz_animal_type_cat');
    Route::post('/sz_animal_type', [AnimalProtectedTypeController::class, 'storeSZAnimalTypes'])->name('store_sz_animal_type');
    Route::get('/sz_animal_type/{animal}', [AnimalProtectedTypeController::class, 'showSZAnimalTypes'])->name('show_sz_animal_type');
    Route::patch('/sz_animal_type/{animal}', [AnimalProtectedTypeController::class, 'updateSZAnimalTypes'])->name('update_sz_animal_type');
    Route::delete('/sz_animal_type/delete/{id}', [AnimalProtectedTypeController::class, 'deleteSZAnimalType'])->name('delete_sz_animal_type');
    // Invazivne
    Route::get('/ij_animal_type', [AnimalInvaziveTypeController::class, 'getIJAnimalTypes'])->name('ij_animal_type');
    Route::get('/ij_animal_type/create', [AnimalInvaziveTypeController::class, 'createIJAnimalTypes'])->name('create_ij_animal_type');
    Route::post('/ij_animal_type/category', [AnimalCategoryController::class, 'store'])->name('create_ij_animal_type_cat');
    Route::post('/ij_animal_type', [AnimalInvaziveTypeController::class, 'storeIJAnimalTypes'])->name('store_ij_animal_type');
    Route::get('/ij_animal_type/{animal}', [AnimalInvaziveTypeController::class, 'showIJAnimalTypes'])->name('show_ij_animal_type');
    Route::patch('/ij_animal_type/{animal}', [AnimalInvaziveTypeController::class, 'updateIJAnimalTypes'])->name('update_ij_animal_type');
    Route::delete('/ij_animal_type/delete/{id}', [AnimalInvaziveTypeController::class, 'deleteIJAnimalType'])->name('delete_ij_animal_type');

    // Zaplijene
    Route::get('/zj_animal_type', [AnimalSeizedTypeController::class, 'getZJAnimalTypes'])->name('zj_animal_type');
    Route::get('/zj_animal_type/create', [AnimalSeizedTypeController::class, 'createZJAnimalTypes'])->name('create_zj_animal_type');
    Route::post('/zj_animal_type/category', [AnimalCategoryController::class, 'store'])->name('create_zj_animal_type_cat');
    Route::post('/zj_animal_type', [AnimalSeizedTypeController::class, 'storeZJAnimalTypes'])->name('store_zj_animal_type');
    Route::get('/zj_animal_type/{animal}', [AnimalSeizedTypeController::class, 'showZJAnimalTypes'])->name('show_zj_animal_type');
    Route::patch('/zj_animal_type/{animal}', [AnimalSeizedTypeController::class, 'updateZJAnimalTypes'])->name('update_zj_animal_type');
    Route::delete('/zj_animal_type/delete/{id}', [AnimalSeizedTypeController::class, 'deleteZJAnimalType'])->name('delete_zj_animal_type');

    // Redovi


    //Import EXCEL
    Route::get('/animal_import', [AnimalImportController::class, 'index'])->name('animal_import.index');

    Route::post('animal_order_import', [AnimalImportController::class, 'animalOrderFileImport'])->name('animal_order_import');
    Route::post('animal_category_import', [AnimalImportController::class, 'animalCategoryFileImport'])->name('animal_category_import');
    Route::post('animal_sz_import', [AnimalImportController::class, 'animalProtectedFileImport'])->name('animal_sz_import');

    Route::post('animal_invazive_import', [AnimalImportController::class, 'animalInvaziveImport'])->name('animal_invazive_import');
    Route::post('animal_seized_import', [AnimalImportController::class, 'animalSeizedImport'])->name('animal_seized_import');


    // Custom
    Route::get('shelter-dt', 'Shelter\ShelterController@indexDataTables')->name('shelter:dt');

    Route::post('animal_item/changeShelter/{id}', 'Animal\AnimalItemController@changeShelter');
    Route::get('animal_item/getId/{id}', 'Animal\AnimalItemController@getId');
    Route::post('animal_item/file', 'Animal\AnimalItemController@file');
    Route::post('animal_item/file/{id}', 'Animal\AnimalItemController@fileDelete');
    Route::get('generate-pdf/{id}', 'Animal\AnimalItemController@generatePDF');

    Route::get('users-dt', 'UserController@indexDataTables')->name('users:dt');
    Route::get("restore/{user_id}", 'UserController@restore');
    Route::get("/roleMapping", 'UserController@roleMapping');
    Route::post("/roleMappingAdd", 'UserController@roleMappingAdd');
});
