<?php

namespace App\Http\Controllers;

use App\Models\AnimalShelterData;
use App\Models\AnimalUnit;
use Illuminate\Http\Request;

class AnimalShelterDataController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnimalShelterData  $animalShelterData
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $animalUnit = AnimalUnit::with('animalShelterData')->where('id', $id)->get();

        return view('animal.animal-shelter-data', compact('animalUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnimalShelterData  $animalShelterData
     * @return \Illuminate\Http\Response
     */
    public function edit(AnimalShelterData $animalShelterData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnimalShelterData  $animalShelterData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnimalShelterData $animalShelterData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnimalShelterData  $animalShelterData
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnimalShelterData $animalShelterData)
    {
        //
    }
}
