<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;

use App\Models\Animal\Animal;
use Yajra\Datatables\Datatables;
use App\Models\Animal\AnimalCode;
use App\Models\Animal\AnimalType;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalCategory;
use App\Models\Animal\AnimalSystemCategory;
use App\Http\Requests\AnimalInvasiveTypeRequest;

class AnimalInvaziveTypeController extends Controller
{

  public function getIJAnimalTypes(Request $request)
  {
    $animalSystemCategory = AnimalSystemCategory::all();

    $animals = Animal::with('animalType', 'animalCategory')
      ->whereHas('animalType', function ($q) {
        $q->where('type_code', 'IJ');
      })->get();

    if ($request->ajax()) {

      return DataTables::of($animals)
        ->addIndexColumn()
        ->addColumn('animal_category', function (Animal $animal) {

          return $animal->animalCategory->latin_name ?? '';
        })
        ->addColumn('animal_system_category', function (Animal $animal) {

          $animalCategory = $animal->animalCategory;
          return $animalCategory->animalSystemCategory->latin_name ?? '';
        })
        ->addColumn('animal_order', function (Animal $animal) {

          $animalCategory = $animal->animalCategory;
          return $animalCategory->animalOrder->order_name ?? '';
        })
        ->addColumn('animal_type', function (Animal $animal) {
          return $animal->animalType->map(function ($type) {

            return  '<button type="button" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="left" title="' . ($type->type_name) . '">
                        ' . $type->type_code . '
                       </button>';
            //  return $type->type_code;
          })->implode('<br>');
        })
        ->addColumn('action', function (Animal $animal) {
          $deleteURL = route('delete_ij_animal_type', [$animal->id]);
          $token = csrf_token();

          return '
          <div class="d-flex align-items-center">
              <a href="/ij_animal_type/' . $animal->id . '" class="btn btn-xs btn-primary mr-2">
                  Uredi
              </a>

              <form action="'. $deleteURL .'" method="POST" class="m-0">
              <input type="hidden" name="_token" value="'.$token.'" />
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="btn btn-xs btn-danger mr-2">
                  Obriši
              </button>
              </form>
          </div>
          ';
        })

        ->rawColumns(['animal_type', 'action'])
        ->make();
    }

    return view('animal.animal_type.ij_animal_type', compact('animalSystemCategory'));
  }

  public function createIJAnimalTypes()
  {
    $animalCategory = AnimalCategory::all();
    $animalSystemCategory = AnimalSystemCategory::all();
    $animalCodes = AnimalCode::all();
    $animalType = AnimalType::where('type_code', 'IJ')->first();

    return view('animal.animal_type.ij_animal_type_create', compact('animalCodes', 'animalCategory', 'animalSystemCategory', 'animalType'));
  }

  public function storeIJAnimalTypes(AnimalInvasiveTypeRequest $request)
  {
    $szAnimal = new Animal;

    $szAnimalCat = AnimalCategory::findOrFail($request->animal_category);
    $szAnimalSystemcat = AnimalSystemCategory::findOrFail($request->animal_system_category);

    $szAnimal->name = $request->name;
    $szAnimal->latin_name = $request->latin_name;

    $szAnimal->animalCategory()->associate($szAnimalCat);
    $szAnimalSystemcat->animalCategory()->save($szAnimalCat);

    $szAnimal->save();

    $szAnimal->animalCodes()->attach($request->animal_code);
    $szAnimal->animalType()->attach($request->animal_type);

    return redirect('ij_animal_type')->with('msg', 'Jedinka je uspješno kreirana.');
  }

  public function showIJAnimalTypes($id)
  {
    $animal = Animal::with('animalType', 'animalCodes', 'animalCategory')
      ->whereHas('animalType', function ($q) {
        $q->where('type_code', 'IJ');
      })->findOrFail($id);



    $selectedCodes = $animal->animalCodes()->get();
    $selectedCat = $animal->animalCategory->id;
    $selectedSystemCat = $animal->animalCategory->animalSystemCategory->id;

    $animalCategory = AnimalCategory::all();
    $animalSystemCategory = AnimalSystemCategory::all();
    $animalCodes = AnimalCode::all();
    $animalTypes = AnimalType::all();

    return view('animal.animal_type.ij_animal_type_show', compact('animal', 'animalCodes', 'animalCategory', 'animalSystemCategory', 'animalTypes', 'selectedCat', 'selectedCodes', 'selectedSystemCat'));
  }

  public function updateIJAnimalTypes(Request $request, $id)
  {
    $category = AnimalCategory::findOrFail($request->animal_category);
    $systemCategory = AnimalSystemCategory::findOrFail($request->animal_system_category);

    $animal = Animal::find($id);
    $animal->name = $request->name;
    $animal->latin_name = $request->latin_name;
    $animal->animalCategory()->associate($category); // animal belongs to animalCategory
    $systemCategory->animalCategory()->save($category); // systemCat hasMany animalCats

    $animal->animalCodes()->sync($request->animal_code); // manyToMany

    $animal->save();

    return redirect()->route('ij_animal_type')->with('msg', 'Jedinka je uspješno izmjenjena.');
  }

  public function deleteIJAnimalType($id)
  {
    $szAnimal = Animal::findOrFail($id);

    $szAnimal->animalCodes()->detach();
    $szAnimal->animalType()->detach();

    $szAnimal->delete();

    return redirect()->back()->with('msg', 'Jedinka je uspješno izbrisana.');
  }
}
