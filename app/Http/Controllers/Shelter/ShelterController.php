<?php

namespace App\Http\Controllers\Shelter;

use App\Models\User;

use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use Yajra\Datatables\Datatables;
use App\Models\Animal\AnimalCode;
use App\Models\Animal\AnimalItem;
use App\Models\Shelter\ShelterType;
use App\Http\Controllers\Controller;
use App\Models\Shelter\ShelterStaff;
use App\Models\Animal\AnimalCategory;
use App\Http\Requests\ShelterPostRequest;
use App\Models\Animal\AnimalSystemCategory;
use App\Models\Shelter\ShelterStaffType;

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

        $shelter = Shelter::create($request->all());

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

        $shelterLegalStaff = ShelterStaff::legalStaff($id)->last();
        $fileLegal = $shelterLegalStaff ? $shelterLegalStaff->getMedia('legal-docs')->first() : '';

        $shelterCareStaff = ShelterStaff::careStaff($id)->last();

        $fileContract = $shelterCareStaff ? $shelterCareStaff->getMedia('contract-docs')->first() : '';
        $fileCertificate = $shelterCareStaff ? $shelterCareStaff->getMedia('certificate-docs')->first() : '';


        $shelterVetStaff = ShelterStaff::vetStaff($id)->last();

        $fileVetContract = $shelterVetStaff ? $shelterVetStaff->getMedia('vet-docs')->first() : '';
        $fileVetDiploma = $shelterVetStaff ? $shelterVetStaff->getMedia('vet-docs')->first() : '';
        $fileVetAmbulance = $shelterVetStaff ? $shelterVetStaff->getMedia('ambulance-docs')->first() : '';

        return view('shelter.shelter.show', [
            'shelter' => $shelter,
            'shelterLegalStaff' => $shelterLegalStaff,
            'fileLegal' => $fileLegal,
            'shelterCareStaff' => $shelterCareStaff,
            'fileContract' => $fileContract,
            'fileCertificate' => $fileCertificate,
            'shelterVetStaff' => $shelterVetStaff,
            'fileVetContract' => $fileVetContract,
            'fileVetDiploma' => $fileVetDiploma,
            'fileVetAmbulance' => $fileVetAmbulance
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
        $shelter->shelter_code = $request->shelter_code;
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

        return response()->json(['msg' => 'success']);
        //return redirect()->route('shelter.index')->with('msg', 'Oporavilište je uspješno uklonjeno');
    }

    public function animalItems($shelterId, $code)
    {
        $animalItem = Shelter::with('animals')
                    ->findOrFail($shelterId)
                    ->animalItems()->with('animalSizeAttributes')
                    ->where('shelter_code', $code)
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
                    <a href="shelter/' . $shelter->id . '" class="btn btn-xs btn-info mr-2">
                        <i class="mdi mdi-tooltip-edit"></i> 
                        Info
                    </a>
                
                    <a href="shelter/' . $shelter->id . '/edit" class="btn btn-xs btn-primary mr-2">
                        <i class="mdi mdi-tooltip-edit"></i> 
                        Edit
                    </a>

                    <a href="javascript:void(0)" id="shelterClick" class="btn btn-xs btn-danger" >
                        <i class="mdi mdi-delete"></i>
                        <input type="hidden" id="shelter_id" value="' . $shelter->id . '" />
                        Delete
                    </a>
                </div>
                ';
            })->make();
    }
}
