<?php

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PodaciController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Shelter\ShelterController;
use App\Http\Controllers\Animal\AnimalSizeController;
use App\Http\Controllers\Animal\AnimalImportController;
use App\Http\Controllers\Animal\AnimalCategoryController;
use App\Http\Controllers\Animal\AnimalMarkTypeController;
use App\Http\Controllers\Animal\AnimalSeizedTypeController;
use App\Http\Controllers\Animal\AnimalInvaziveTypeController;
use App\Http\Controllers\Animal\AnimalProtectedTypeController;
use App\Http\Controllers\Animal\AnimalItemCareEndTypeController;
use App\Http\Controllers\Animal\AnimalItemDocumentationController;


Route::get("/adminer", function() {
    ob_start();
    require(path("public")."adminer.php");
    return ob_get_clean();
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::get('/test', function () {
        return view('sample');
    });

    // Logout
    Route::get('logout', [LoginController::class, 'logout']);

    Route::resource('shelter', Shelter\ShelterController::class);
    Route::resource('shelter_legal_staff', Shelter\ShelterLegalStaffController::class);
    Route::resource('shelter_care_staff', Shelter\ShelterCareStaffController::class);
    Route::resource('shelter_vet_staff', Shelter\ShelterVetStaffController::class);
    Route::resource('shelter_personel_staff', Shelter\ShelterPersonelStaffController::class);
    Route::resource('animal_item', Animal\AnimalItemController::class);
    Route::resource('animal', Animal\AnimalController::class);
    Route::resource('animal_category', Animal\AnimalCategoryController::class);
    Route::resource('user', UserController::class);
    Route::resource('animal_size', Animal\AnimalSizeController::class);
    Route::get('get_animal_size', [AnimalSizeController::class, 'getSizes'])->name('get_animal_size');
    Route::resource('animal_order', Animal\AnimalOrderController::class);
    Route::resource('shelters.animal_groups.animal_items', Animal\AnimalItemController::class);
    Route::resource('animal_groups.animal_logs', Animal\AnimalGroupLogController::class);
    Route::resource('animal_items.animal_item_logs', Animal\AnimalItemLogController::class);
    Route::resource('shelters.animal_groups.animal_items.animal_item_documentations', Animal\AnimalItemDocumentationController::class);

    Route::resource('shelters.animal_groups', Animal\AnimalGroupController::class);
    Route::resource('animal_items.euthanasia', Animal\EuthanasiaController::class);
    Route::resource('shelters.animal_groups.animal_items.animal_item_care_end', Animal\AnimalItemCareEndController::class)->only(['index']);
    Route::post('getVet', 'Animal\AnimalItemCareEndController@getVet')->name('getVet');
    Route::get('shelter{shelter}/animal_group{animalGroup}', 'Animal\AnimalGroupController@animalItemInactive')->name('animal_item_inactive');
    Route::get('animal_group{animalGroup}', 'Animal\AnimalGroupController@animalAnotherShelter')->name('animal_item_another_shelter');

    // Change Shelter
    Route::post('animal_group/{animalGroup}', 'Animal\AnimalGroupController@groupChangeShelter');
    Route::post('animal_item/{animalItem}', 'Animal\AnimalItemController@changeShelter');
    //Clone testing
    Route::get('animal_item/clone/{animalItem}', 'Animal\AnimalItemController@cloneAnimalItem')->name('animal_item.clone');
    // Change Shelter

    Route::post('animal_item/full-care/{animalItem}', 'Animal\AnimalItemController@activeFullCare')->name('animal_item.fullcare');

    Route::resource('shelters.accomodations', Shelter\ShelterAccomodationController::class)->parameters([
        'accomodations' => 'shelter_accomodation'
    ]);

    // Restore Shelter
    Route::get("restore/{shelter}", 'Shelter\ShelterController@restore')->name('shelter-restore');

    // delete images
    Route::get('accomodation/thumb/{thumb}', 'Shelter\ShelterAccomodationController@deleteImage')->name('accomodation.thumbDelete');
    Route::get('animal_item_log/thumb/{thumb}', 'Animal\AnimalItemLogController@deleteImage')->name('animal_item_log.thumbDelete');
    Route::get('animal_item_documentation/thumb/{thumb}', 'Animal\AnimalItemDocumentationController@deleteImage')->name('item_documentation.thumbDelete');
    Route::get('equipment/thumb/{thumb}', 'Shelter\ShelterEquipmentController@deleteImage')->name('equipment.thumbDelete');

    Route::resource('shelters.nutritions', Shelter\ShelterNutritionController::class)->parameters([
        'nutritions' => 'shelter_nutrition'
    ]);

    Route::resource('shelters.equipments', Shelter\ShelterEquipmentController::class)->parameters([
        'equipments' => 'shelter_equipment'
    ]);

    Route::get('shelter/{shelterId}/animal/{animalId}', [ShelterController::class, 'animalItems']);
    // get all shelter staff
    Route::get('shelter/{shelter}/shelter_staff', [ShelterController::class, 'getShelterStaff'])->name('shelter.shelter_staff');

    /*
    |--------------------------------------------------------------------------
    | Animal Types
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Import EXCEL
    |--------------------------------------------------------------------------
    */
    Route::get('/animal_import', [AnimalImportController::class, 'index'])->name('animal_import.index');
    Route::post('animal_order_import', [AnimalImportController::class, 'animalOrderFileImport'])->name('animal_order_import');
    Route::post('animal_category_import', [AnimalImportController::class, 'animalCategoryFileImport'])->name('animal_category_import');
    Route::post('animal_sz_import', [AnimalImportController::class, 'animalProtectedFileImport'])->name('animal_sz_import');
    Route::post('animal_invazive_import', [AnimalImportController::class, 'animalInvaziveImport'])->name('animal_invazive_import');
    Route::post('animal_seized_import', [AnimalImportController::class, 'animalSeizedImport'])->name('animal_seized_import');

    Route::post('createAnimalSystemCat', 'Shelter\ShelterController@createAnimalSystemCat')->name('createAnimalSystemCat');

    Route::get('size/get_by_animal', 'Animal\AnimalController@getBySize')->name('animals.get_by_size');

    // Founder
    Route::resource('shelters.founders', FounderDataController::class);
    Route::get('shelters/{shelter}/founder_modal', 'FounderDataController@modalCreateFounder')->name('founder.modal');
    Route::post('/founder_create', 'FounderDataController@createFounder');
    Route::post('/reload_founder', 'FounderDataController@getFounder')->name('reload_founder');
    Route::get('founder/fileDelete/{file}', 'FounderDataController@fileDelete')->name('founder.fileDelete');

    Route::resource('founder-service', FounderServiceController::class);

    // Animal create START
    Route::get('shelters/{shelter}/animal/create', 'Animal\AnimalShelterCreateController@createView')->name('shelterAnimal.create');
    Route::post('animals/getfounders', 'Animal\AnimalShelterCreateController@getFounder')->name('shelterAnimal.getfounder');
    Route::post('animals/getForms', 'Animal\AnimalShelterCreateController@getForm')->name('shelterAnimal.getForm');

    Route::post('animals/protected_store', 'Animal\AnimalShelterCreateController@protectedStore')->name('shelterAnimal.protectedStore');
    Route::post('animals/invasive_store', 'Animal\AnimalShelterCreateController@invasiveStore')->name('shelterAnimal.invasiveStore');
    Route::post('animals/seized_store', 'Animal\AnimalShelterCreateController@seizedStore')->name('shelterAnimal.seizedStore');
    // Animal create END

    Route::delete('/delete_state_found/{animalItem}', 'Animal\AnimalItemDocumentationController@deleteStateFound');

    // Update AnimalItem Date, Price
    Route::post('animalItem/update/{id}', 'Animal\AnimalItemPriceController@updateDateAndPrice');

    Route::post('animalItem/file', 'Animal\AnimalItemController@file')->name('animaItem.addedFile');
    Route::get('animalItem/fileDelete/{file}', 'Animal\AnimalItemController@deleteFile')->name('animalItem.fileDelete');

    Route::get("restore/{user_id}", 'UserController@restore');
    Route::get("/roleMapping", 'UserController@roleMapping')->name('roleMapping');
    Route::post("/role-mapping-add", 'UserController@roleMappingAdd')->name("role-mapping-add");
    Route::post("/permission-mapping", 'UserController@permissionMapping')->name("permissionAdd");

    // Podaci
    Route::get("/podaci", [PodaciController::class, 'index'])->name('podaci-index');
    Route::post("/podaci-animal-dob", [PodaciController::class, 'animal_dob'])->name('podaci-animal-dob');
    Route::post("/animal-solitary-group", [PodaciController::class, 'animal_solitary_group'])->name('animal-solitary-group');
    Route::post("/podaci-founder-services", [PodaciController::class, 'founder_services'])->name('podaci-founder-services');
    Route::post("/podaci-animal-status", [PodaciController::class, 'animal_status'])->name('podaci-animal-status');
    Route::post("/animal-care-end-status", [PodaciController::class, 'animal_care_end_status'])->name('animal-care-end-status');
    Route::post("/podaci-location-animal-takeover", [PodaciController::class, 'location_animal_takeover'])->name('podaci-location-animal-takeover');

    // Reports
    Route::get('view-reports', 'ReportController@viewReports')->name("report-view");
    Route::post('reports-status/{report}', 'ReportController@changeStatus')->name("report-status");
    Route::get('reports-modal', 'ReportController@createModal')->name("report-modal");
    Route::delete('reports-delete/{report}', 'ReportController@deleteReport')->name("report-delete");
    Route::post('report-save', 'ReportController@saveReport')->name("report-save");
    Route::post('reports-zns', 'ReportController@generateZNS')->name('reports-zns');
    Route::post('report-export-excel', 'ReportController@exportToExcel')->name('export-to-excel');
});
