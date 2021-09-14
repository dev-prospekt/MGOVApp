<?php

namespace App\Http\Controllers\Shelter;

use App\Models\User;

use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalCode;
use App\Models\Animal\AnimalItem;
use App\Models\Shelter\ShelterType;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalCategory;
use App\Http\Requests\ShelterPostRequest;
use App\Models\Animal\AnimalSystemCategory;
use Yajra\Datatables\Datatables;

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
        $shelterType = ShelterType::all();

        return view("shelter.shelter.create", [
            'shelterType' => $shelterType
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShelterPostRequest $request)
    {
        $shelter = new Shelter;
        $shelter->name = $request->name;
        $shelter->shelterCode = $request->shelterCode;
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

        $shelter->shelterTypes()->attach($request->shelter_type_id, [
            'shelter_id' => $shelter->id
        ]);

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
        $shelter = Shelter::with('animals', 'users')->findOrFail($id);

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
        $shelterType = ShelterType::all();

        return view('shelter.shelter.edit', [
            'shelterType' => $shelterType,
            'shelter' => $shelter
        ]); 
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
        $shelter->shelterCode = $request->shelterCode;
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

        $shelter->shelterTypes()->sync($request->shelter_type_id, [
            'shelter_id' => $shelter->id
        ]);

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

        return response()->json(['msg'=>'success']);
        //return redirect()->route('shelter.index')->with('msg', 'Oporavilište je uspješno uklonjeno');
    }

    public function animalItems($shelterId, $code)
    {
        $animalItem = Shelter::with('animals')
                        ->findOrFail($shelterId)
                        ->animalItems()
                        ->where('shelterCode', $code)
                        ->where('status', 1)
                        ->get();
                        
        $shelters = Shelter::all();
        //dd($animalItem);

        return view('animal.animal_item.show', compact('animalItem', 'shelters'));
    }

    public function indexDataTables()
    {
        $shelters = Shelter::all();

        return Datatables::of($shelters)
            ->addColumn('action', function ($shelter) {
                return '
                <div class="d-flex align-items-center">
                    <a href="shelter/'.$shelter->id.'" class="btn btn-xs btn-info mr-2">
                        <i class="mdi mdi-tooltip-edit"></i> 
                        Info
                    </a>
                
                    <a href="shelter/'.$shelter->id.'/edit" class="btn btn-xs btn-primary mr-2">
                        <i class="mdi mdi-tooltip-edit"></i> 
                        Edit
                    </a>

                    <a href="javascript:void(0)" id="shelterClick" class="btn btn-xs btn-danger" >
                        <i class="mdi mdi-delete"></i>
                        <input type="hidden" id="shelter_id" value="'.$shelter->id.'" />
                        Delete
                    </a>
                </div>
                ';
            })->make(true);
    }
}
