<?php

namespace App\Http\Controllers\Animal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalCode;
use App\Models\Animal\AnimalFile;
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
        $shelter = Shelter::findOrFail(auth()->user()->shelter->id)
            ->shelterTypes()
            ->get();

        foreach ($shelter as $key) {
            if($key->code == "IJ"){
                $ij = Animal::with('animalType')
                            ->whereHas('animalType', function ($q) use ($key) {
                                $q->where('type_code', $key->code);
                            })->get();
            }
            if($key->code == "SZJ"){
                $szj = Animal::with('animalType')
                            ->whereHas('animalType', function ($q) use ($key) {
                                $q->where('type_code', $key->code);
                            })->get();
            }
            if($key->code == "ZJ"){
                $zj = Animal::with('animalType')
                            ->whereHas('animalType', function ($q) use ($key) {
                                    $q->where('type_code', $key->code);
                                })->get();
            }
        }

        if(empty($ij)){
            $ij = '';
        }
        if(empty($szj)){
            $szj = '';
        }
        if(empty($zj)){
            $zj = '';
        }
                
        return view('animal.animal.create', [
            'ij' => $ij,
            'szj' => $szj,
            'zj' => $zj,
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

        // Pivot table
        $animals->shelters()->attach($request->animal_id, [
            'shelter_id' => $request->shelter_id,
            'animal_id' => $request->animal_id,
            'shelter_code' => Carbon::now()->format('Y') .''. $request->shelter_code .'-'. $increment,
            'quantity' => $request->quantity,
        ]);

        // Pivot id (animal_shelter)
        $pivot_id = Animal::find($request->animal_id)->shelters()->orderBy('pivot_id', 'desc')->first();

        // Create AnimalFile
        $animalFiles = new AnimalFile;
        $animalFiles->animal_shelter_id = $pivot_id->pivot->id; // ID pivot table animal_shelter
        $animalFiles->shelter_code = Carbon::now()->format('Y') .''. $request->shelter_code .'-'. $increment; // shelter_code
        $animalFiles->save();

        // Save documents - Model AnimalFile
        if($request->filenames){
            foreach ($request->filenames as $key) {
                $animalFiles->addMedia($key)->toMediaCollection('media');
            }
        }

        // Create AnimalItem
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
            $animalItem->date_found = Carbon::createFromFormat('m/d/Y', $request->date_found)->format('d.m.Y');
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
