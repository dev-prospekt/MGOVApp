<?php

namespace App\Http\Controllers\Shelter;

use App\Models\User;

use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalCategory;
use App\Models\Animal\AnimalSystemCategory;

class ShelterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shelters = Shelter::all();

        return view('shelter.shelter.index', [
            'shelters' => $shelters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("shelter.shelter.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shelter = new Shelter;
        $shelter->name = $request->name;
        $shelter->email = $request->email;
        $shelter->address = $request->address;
        $shelter->oib = $request->oib;
        $shelter->place_zip = $request->place_zip;
        $shelter->bank_name = $request->bank_name;
        $shelter->telephone = $request->telephone;
        $shelter->mobile = $request->mobile;
        $shelter->fax = $request->fax;
        $shelter->web_address = $request->web_address;
        $shelter->iban = $request->iban;
        $shelter->save();

        return redirect()->route("shelter.index")->with('msg', 'Uspješno dodano.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shelter  $shelter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shelter = Shelter::with('shelterTypes', 'users', 'animals')->findOrFail($id);

        return view('shelter.shelter.show', [
            'shelter' => $shelter,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shelter  $shelter
     * @return \Illuminate\Http\Response
     */
    public function edit(Shelter $shelter)
    {
        return view('shelter.shelter.edit')->with('shelter', $shelter); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shelter  $shelter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shelter = Shelter::findOrFail($id);
        $shelter->name = $request->name;
        $shelter->email = $request->email;
        $shelter->address = $request->address;
        $shelter->oib = $request->oib;
        $shelter->place_zip = $request->place_zip;
        $shelter->bank_name = $request->bank_name;
        $shelter->telephone = $request->telephone;
        $shelter->mobile = $request->mobile;
        $shelter->fax = $request->fax;
        $shelter->web_address = $request->web_address;
        $shelter->iban = $request->iban;
        $shelter->save();

        return redirect()->route("shelter.index")->with('msg', 'Uspješno ažurirano.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shelter  $shelter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shelter = Shelter::findOrFail($id);
        $shelter->delete();

        return redirect()->route('shelter.index')->with('msg', 'Oporavilište je uspješno uklonjeno');
    }

    public function animalItems($shelterId, $animalId)
    {
        $animalItem = Shelter::findOrFail($shelterId)
                        ->animalItems()->where('animal_id', $animalId)
                        ->with('animal')
                        ->get();

        //dd($animalItem);

        return view('animal.animal.show', [
            'animal' => $animalItem,
        ]);
    }
}
