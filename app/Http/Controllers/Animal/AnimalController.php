<?php

namespace App\Http\Controllers\Animal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalCode;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalSize;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnimalPostRequest;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $animals = Animal::with('animalType', 'animalCodes', 'animalCategory')->get();

        return view('animal.animal.index', compact('animals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $animals = Animal::all();
        $animalsCode = AnimalCode::all();
        $animalSize = AnimalSize::all();

        return view('animal.animal.create', [
            'animals' => $animals,
            'animalsCode' => $animalsCode,
            'animalSize' => $animalSize,
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnimalPostRequest $request)
    {
        $animals = new Animal;
        $count = $request->quantity;

        // Increment ID
        $incrementId = DB::table('animal_shelter')->orderBy('id', 'DESC')->first();
        if(empty($incrementId->id)){
            $increment = 1;
        }
        else {
            $increment = $incrementId->id + 1;
        }

        $animals->shelters()->attach($request->animal_id, [
            'shelter_id' => $request->shelter_id,
            'animal_id' => $request->animal_id,
            'shelter_code' => Carbon::now()->format('Y') .''. $request->shelter_code .'-'. $increment,
            'quantity' => $request->quantity,
        ]);

        $animals->animalCodes()->attach($request->animal_code_id, [
            'animal_id' => $request->animal_id
        ]);

        for ($i=0; $i < $count; $i++) {
            $animalItem = new AnimalItem;
            $animalItem->animal_id = $request->animal_id;
            $animalItem->shelter_id = $request->shelter_id;
            
            if($count != 1){
                $animalItem->solitary_or_group = 1;
            }
            else {
                $animalItem->solitary_or_group = 0;
            }

            $animalItem->shelter_code = Carbon::now()->format('Y') .''. $request->shelter_code .'-'. $increment;
            $animalItem->status = 1;
            $animalItem->date_found = Carbon::createFromFormat('Y-m-d', $request->date_found)->format('d.m.Y');
            $animalItem->save();
        }
        
        return redirect()->route('shelter.show', $request->shelter_id)->with('msg', 'Uspješno dodano.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $animal = Animal::with('animalCodes', 'animalCategory', 'animalAttributes', 'animalItems', 'shelters')->findOrFail($id);

        return view('animal.animal_item.show', [
            'animal' => $animal,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $animal = Animal::find($id);

        return view('animal.animal.edit')->with('animals', $animal); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
