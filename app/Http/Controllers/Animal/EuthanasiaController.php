<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\Euthanasia;
use App\Http\Controllers\Controller;

class EuthanasiaController extends Controller
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
    public function store(AnimalItem $animalItem, Request $request)
    {
        //dd($request);

        $euthanasia = new Euthanasia;
        $euthanasia->animal_item_id = $animalItem->id;
        $euthanasia->shelter_staff_id = $request->staff;
        $euthanasia->price = $request->price;
        $euthanasia->save();

        if(!empty($request->euthanasia_file)){
            $euthanasia->addMedia($request->euthanasia_file)->toMediaCollection('euthanasia_file');
        }

        return redirect()->back()->with('euthanasiaMsg', 'Uspješno dodano');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Euthanasia $euthanasia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Euthanasia $euthanasia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Euthanasia $euthanasia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Euthanasia $euthanasia)
    {
        //
    }
}
