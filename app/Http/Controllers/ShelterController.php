<?php

namespace App\Http\Controllers;

use App\Models\AnimalUnit;
use App\Models\Shelter;
use Illuminate\Http\Request;

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
        return view('shelter.index', compact('shelters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shelter.create');
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
     * @param  \App\Models\Shelter  $shelter
     * @return \Illuminate\Http\Response
     */
    public function show(Shelter $shelter)
    {
        return view('shelter.show')->with('shelter', $shelter);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shelter  $shelter
     * @return \Illuminate\Http\Response
     */
    public function edit(Shelter $shelter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shelter  $shelter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shelter $shelter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shelter  $shelter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shelter $shelter)
    {
        //
    }
}
