<?php

namespace App\Http\Controllers\Shelter;

use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Shelter\ShelterAccomodation;
use App\Models\Shelter\ShelterAccomodationType;

class ShelterAccomodationController extends Controller
{
    public function index(Shelter $shelter)
    {

        $shelterAccomodationItems = ShelterAccomodation::with('accommodationType')->where('shelter_id', $shelter->id)->get();
        return view('shelter.shelter_accomodation.index', compact('shelterAccomodationItems', 'shelter'));
    }

    public function create()
    {
        $accomodation_types = ShelterAccomodationType::all('id', 'name');

        $returnHTML = view('shelter.shelter_accomodation._create', ['accomodation_types' => $accomodation_types])->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


    public function store(Request $request, Shelter $shelter)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'accomodation_name' => 'required',
                'accomodation_size' => 'required',
                'accomodation_desc' => 'required',
            ],
            [
                'accomodation_name.required' => 'Naziv je obvezano polje',
                'accomodation_size.required' => 'Dimenzije su obvezano polje',
                'accomodation_desc.required' => 'Opis je obvezno polje',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $accomodation_type = ShelterAccomodationType::findOrFail($request->accomodation_type);
        $shelter_id = $shelter->id;

        $shelter_accomodation = ShelterAccomodation::create([
            'shelter_id' => $shelter_id,
            'shelter_accomodation_type_id' => $accomodation_type->id,
            'name' => $request->accomodation_name,
            'dimensions' => $request->accomodation_size,
            'description' => $request->accomodation_desc
        ]);
        $accomodation_type->shelterAccomodation()->save($shelter_accomodation);

        if ($request->hasFile('accomodation_photos')) {
            foreach ($request->file('accomodation_photos') as $image) {
                $shelter_accomodation->addMedia($image)->toMediaCollection('accomodation-photos');
            }
        }

        return response()->json(['success' => 'Smještajna jedinica uspješno spremljena.']);
    }

    public function show(Shelter $shelter, ShelterAccomodation $shelter_accomodation)
    {

        return view('shelter.shelter_accomodation.show', ['shelterAccomodationItem' => $shelter_accomodation, 'shelter' => $shelter]);
    }

    public function edit(Shelter $shelter, ShelterAccomodation $shelter_accomodation)
    {
        return view('shelter.shelter_accomodation.edit', ['shelterAccomodationItem' => $shelter_accomodation, 'shelter' => $shelter]);
    }

    public function update(Request $request, Shelter $shelter, ShelterAccomodation $shelter_accomodation)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'edit_accomodation_name' => 'required',
                'edit_accomodation_size' => 'required',
                'edit_accomodation_desc' => 'required',
            ],
            [
                'edit_accomodation_name.required' => 'Naziv je obvezano polje',
                'edit_accomodation_size.required' => 'Dimenzije su obvezano polje',
                'edit_accomodation_desc.required' => 'Opis je obvezno polje',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $shelter_accomodation->update([
            'name' => $request->edit_accomodation_name,
            'dimensions' => $request->edit_accomodation_size,
            'description' => $request->edit_accomodation_desc
        ]);

        if ($request->hasFile('edit_accomodation_photos')) {
            foreach ($request->file('edit_accomodation_photos') as $image) {
                $shelter_accomodation->addMedia($image)->toMediaCollection('accomodation-photos');
            }
        }
        return response()->json(['success' => 'Smještajna jedinica uspješno spremljena.']);
    }

    public function destroy(Shelter $shelter, ShelterAccomodation $shelter_accomodation)
    {
        $shelter_accomodation->delete();
        return response()->json(['success' => 'Smještajna jedinica uspješno izbrisana.']);
    }
}
