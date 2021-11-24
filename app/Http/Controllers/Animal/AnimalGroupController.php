<?php

namespace App\Http\Controllers\Animal;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\Animal\AnimalGroup;
use App\Http\Controllers\Controller;

class AnimalGroupController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $animal_group = AnimalGroup::with('animalItems', 'shelters')->find($id);
        $animal_items = $animal_group->animalItems;

        if($request->ajax())
        {
            return DataTables::of($animal_items)
            ->addIndexColumn()
            ->addColumn('name', function ($animal_items) {
                return $animal_items->animal->name;
            })
            ->addColumn('latin_name', function ($animal_items) {
                return $animal_items->animal->latin_name;
            })
            ->make();
        }

        return view('animal.animal_group.show', [
            'animal_group' => $animal_group,
            'animal_items' => $animal_items
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
        //
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
        //
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
