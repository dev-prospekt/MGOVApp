<?php

namespace App\Http\Controllers;

use App\Models\Shelter\ShelterStaff;
use Illuminate\Http\Request;

class ShelterStaffController extends Controller
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
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shelter\ShelterStaff  $shelterStaff
     * @return \Illuminate\Http\Response
     */
    public function show(ShelterStaff $shelterStaff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shelter\ShelterStaff  $shelterStaff
     * @return \Illuminate\Http\Response
     */
    public function edit(ShelterStaff $shelterStaff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shelter\ShelterStaff  $shelterStaff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShelterStaff $shelterStaff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shelter\ShelterStaff  $shelterStaff
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShelterStaff $shelterStaff)
    {
        //
    }
}
