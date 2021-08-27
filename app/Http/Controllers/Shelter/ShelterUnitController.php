<?php

namespace App\Http\Controllers\Shelter;

use App\Models\User;

use Illuminate\Http\Request;
use App\Models\Animal\AnimalItem;
use App\Models\Shelter\ShelterUnit;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalSystemCategory;

class ShelterUnitController extends Controller
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
     * @param  \App\Models\ShelterUnit  $shelterUnit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shelterUnit = ShelterUnit::with('shelterTypes', 'users', 'animalItems')->findOrFail($id);
        $animalCat = AnimalSystemCategory::with('animalCategories')->findOrFail($id);

        return view('shelter.shelter_unit.show', [
            'shelterUnit' => $shelterUnit,
            'animalCat' => $animalCat
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShelterUnit  $shelterUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(ShelterUnit $shelterUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShelterUnit  $shelterUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShelterUnit $shelterUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShelterUnit  $shelterUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShelterUnit $shelterUnit)
    {
        //
    }
}
