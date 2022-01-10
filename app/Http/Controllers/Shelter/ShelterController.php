<?php

namespace App\Http\Controllers\Shelter;

use Carbon\Carbon;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use Yajra\Datatables\Datatables;
use App\Models\Animal\AnimalCode;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalType;
use Illuminate\Support\Facades\DB;
use App\Models\Shelter\ShelterType;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Shelter\ShelterStaff;
use App\Models\Animal\AnimalCategory;
use App\Models\Shelter\ShelterStaffType;
use App\Http\Requests\ShelterPostRequest;
use App\Models\Animal\AnimalSystemCategory;

class ShelterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shelters = Shelter::all();

        if ($request->ajax()) {
            return Datatables::of($shelters)
                ->addColumn('action', function ($shelter) {
                    return '
                    <div class="d-flex align-items-center">
                        <a href="shelter/' . $shelter->id . '" class="btn btn-xs btn-info mr-2"> 
                            Podaci
                        </a>
                    
                        <a href="shelter/' . $shelter->id . '/edit" class="btn btn-xs btn-primary mr-2"> 
                            Uredi
                        </a>

                        <a href="javascript:void(0)" id="shelterClick" class="btn btn-xs btn-danger" >
                            <input type="hidden" id="shelter_id" value="' . $shelter->id . '" />
                            Obriši
                        </a>
                    </div>
                    ';
                })->make();
        }

        return view('shelter.index', [
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

        //Last shelter ID
        $shelterID = DB::table('shelters')->orderBy('id', 'DESC')->first();
        $shelter = Shelter::with('shelterTypes')->findOrFail($shelterID->id);

        $type = array('shelterType' => $shelter->shelterTypes);
        foreach ($shelter->shelterTypes as $item) {
            $type['type'] = $item->animalSystemCategory;
        }

        return view("shelter.create", [
            'shelterType' => $shelterType,
            'type' => $type,
        ]);
    }

    public function createAnimalSystemCat(Request $request)
    {
        //dd($request);

        $shelter = Shelter::find($request->shelter_id);
        $shelter->animalSystemCategory()->attach($request->animal_system_category_id, [
            'shelter_id' => $shelter->id
        ]);

        return redirect()->route("shelter.show", $shelter->id)->with('finishMSG', 'Uspješno spremljeno.');
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

        $shelter->register_date = Carbon::createFromFormat('m/d/Y', $request->register_date);
        $shelter->save();

        $shelter->shelterTypes()->attach($request->shelter_type_id, [
            'shelter_id' => $shelter->id
        ]);

        return redirect()->route("shelter.create")
            ->with('msg', 'Uspješno dodano.')
            ->with('active', 'Možete izabrati jedinke.')
            ->with('shelter_id', $shelter->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shelter  $shelter
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $shelters = Shelter::with('users', 'animalGroups')->findOrFail($id);
        $animal_groups = $shelters->animalGroups;

        if ($request->ajax()) {
            return Datatables::of($animal_groups)
                ->addIndexColumn()
                ->addColumn('animal_count_active', function ($animal_groups) {
                    return $animal_groups->animalItemActive->count();
                })
                ->addColumn('animal_count_inactive', function ($animal_groups) {
                    return $animal_groups->animalItemInactive->count();
                })
                ->addColumn('name', function ($animal_groups) {
                    return $animal_groups->animal->name;
                })
                ->addColumn('latin_name', function ($animal_groups) {
                    return $animal_groups->animal->latin_name;
                })
                ->addColumn('animal_type', function ($animal_groups) {
                    return $animal_groups->animal->animalType->map(function ($type) {
                        switch ($type->type_code) {
                            case "SZJ":
                                $btn_class = 'warning';
                                break;
                            case "IJ":
                                $btn_class = 'danger';
                                break;
                            case "ZJ":
                                $btn_class = 'info';
                                break;

                            default:
                                $btn_class = 'light';
                        }
                        return  '<button type="button" class="btn btn-xs btn-' . ($btn_class) . '" data-toggle="tooltip" data-placement="left" title="' . ($type->type_name) . '">
                        ' . $type->type_code . '
                       </button>';
                    })->implode('<br>');
                })
                ->addColumn('action', function ($animal_groups) {
                    $deleteURL = route('shelters.animal_groups.destroy', [$animal_groups->pivot->shelter_id, $animal_groups->id]);

                    return '
                    <div class="d-flex align-items-center">
                        <a href="/shelters/' . $animal_groups->pivot->shelter_id . '/animal_groups/' . $animal_groups->id . '" class="btn btn-xs btn-info mr-2"> 
                            Podaci
                        </a>
                        <a href="javascript:void(0)" data-href="' . $deleteURL . '" id="animal_group_delete" class="btn btn-xs btn-danger" >
                            Brisanje
                        </a>
                    </div>
                    ';
                })
                ->rawColumns(['animal_type', 'action'])
                ->make();
        }

        return view('shelter.show', ['shelter' => $shelters]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shelter  $shelter
     * @return \Illuminate\Http\Response
     */
    public function edit(Shelter $shelter)
    {
        if(auth()->user()->hasPermissionTo('edit') == false){ return redirect()->back(); }

        $shelterTypes = ShelterType::all();
        $selectedShelterTypes = $shelter->shelterTypes()->get();

        return view('shelter.edit', [
            'shelterTypes' => $shelterTypes,
            'selectedShelterTypes' => $selectedShelterTypes,
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
    public function update(ShelterPostRequest $request, $id)
    {

        $shelter = Shelter::findOrFail($id);
        $shelter->name = $request->name;
        $shelter->shelter_code = $request->shelter_code;
        $shelter->email = $request->email;
        $shelter->address = $request->address;
        $shelter->address_place = $request->address_place;
        $shelter->oib = $request->oib;
        $shelter->place_zip = $request->place_zip;
        $shelter->bank_name = $request->bank_name;
        $shelter->register_date =  Carbon::createFromFormat('m/d/Y', $request->register_date);
        $shelter->telephone = $request->telephone;
        $shelter->mobile = $request->mobile;
        $shelter->fax = $request->fax;
        $shelter->web_address = $request->web_address;
        $shelter->iban = $request->iban;
        $shelter->save();

        $shelter->shelterTypes()->sync($request->shelter_type_id, [
            'shelter_id' => $shelter->id
        ]);

        return redirect()->route("shelter.show", $shelter->id)->with('update_shelter', 'Uspješno ažurirano.');
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
        $shelter->shelterTypes()->detach();
        $shelter->animalSystemCategory()->detach();
        $shelter->delete();

        return response()->json(['msg' => 'success']);
        //return redirect()->route('shelter.index')->with('msg', 'Oporavilište je uspješno uklonjeno');
    }

    public function getShelterStaff(Shelter $shelter)
    {
        /*Shelter staff type users*/
        $shelterLegalStaff = ShelterStaff::legalStaff($shelter->id)->last();
        $fileLegal = $shelterLegalStaff ? $shelterLegalStaff->getMedia('legal-docs')->first() : '';

        $shelterCareStaff = ShelterStaff::careStaff($shelter->id)->last();

        $fileContract = $shelterCareStaff ? $shelterCareStaff->getMedia('contract-docs')->first() : '';
        $fileCertificate = $shelterCareStaff ? $shelterCareStaff->getMedia('certificate-docs')->first() : '';

        $shelterVetStaff = ShelterStaff::vetStaff($shelter->id)->last();

        $fileVetContract = $shelterVetStaff ? $shelterVetStaff->getMedia('contract-docs')->first() : '';
        $fileVetDiploma = $shelterVetStaff ? $shelterVetStaff->getMedia('vet-docs')->first() : '';
        $fileVetAmbulance = $shelterVetStaff ? $shelterVetStaff->getMedia('ambulance-docs')->first() : '';

        $shelterPersonelStaff = ShelterStaff::personelStaff($shelter->id)->all();

        return view('shelter.shelter_staff', [
            'shelter' => $shelter,
            'shelterLegalStaff' => $shelterLegalStaff,
            'fileLegal' => $fileLegal,
            'shelterCareStaff' => $shelterCareStaff,
            'fileContract' => $fileContract,
            'fileCertificate' => $fileCertificate,
            'shelterVetStaff' => $shelterVetStaff,
            'fileVetContract' => $fileVetContract,
            'fileVetDiploma' => $fileVetDiploma,
            'fileVetAmbulance' => $fileVetAmbulance,
            'shelterPersonelStaff' => $shelterPersonelStaff
        ]);
    }
}
