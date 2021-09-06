<?php

namespace App\Http\Controllers\Animal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $animals = Animal::all();

        return view('animal.animal.create', [
            'animals' => $animals
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        $animals->shelters()->attach([$request['animal_id'] => [
            'shelter_id' => $request['shelter_id'],
            'animal_id' => $request['animal_id'],
            'shelterCode' => Carbon::now()->format('Y') .''. $request['shelterCode'] .'-'. $increment,
            'quantity' => $request['quantity'],
        ]]);

        for ($i=0; $i < $count; $i++) { 
            $animalItem = new AnimalItem;
            $animalItem->animal_id = $request->animal_id;
            $animalItem->shelter_id = $request->shelter_id;
            $animalItem->shelterCode = Carbon::now()->format('Y') .''. $request->shelterCode .'-'. $increment;
            $animalItem->status = 1;
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

        return view('animal.animal.show', [
            'animal' => $animal,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AnimalItem $animal)
    {
        return view('animal.animal.edit')->with('animal', $animal); 
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
        $animalItem = AnimalItem::find($id);
        $animalItem->animal_size = $request->animal_size;
        $animalItem->animal_gender = $request->animal_gender;
        $animalItem->location = $request->location;
        $animalItem->save();

        return redirect('/shelter/'.$animalItem->shelter_id.'/animal/'.$animalItem->shelterCode)->with('msg', 'Uspješno ažurirano.');
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
