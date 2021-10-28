<?php

namespace App\Http\Controllers\Shelter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Shelter\ShelterAccomodation;
use App\Models\Shelter\ShelterAccomodationType;
use App\Http\Requests\ShelterAccomodationBoxRequest;
use App\Http\Requests\ShelterAccomodationPlaceRequest;

class ShelterAccomodationController extends Controller
{
    public function index(Request $request)
    {
        $shelter_id = $request->shelter;
        $shelterAccomodationItems = ShelterAccomodation::with('accommodationType', 'shelter')->where('shelter_id', $shelter_id)->get();
        /* 
        $thumbnail_images = $shelterAccomodationItems->map(function ($item) {
            return $item->getMedia('accomodation-photos');
        })->flatten(); */

        /*  $shelterAccomodationPlace = ShelterAccomodation::with('accommodationType')->where('shelter_id', $shelter_id)
            ->whereHas('accommodationType', function ($q) {
                $q->where('type', 'prostor');
            })->get(); */

        return view('shelter.shelter_accomodation.index', compact('shelter_id', 'shelterAccomodationItems'));
    }

    public function create(Request $request)
    {
        $accomodation_shelter = ShelterAccomodationType::where('type', 'nastamba')->get();
        $accomodation_place = ShelterAccomodationType::where('type', 'prostor')->get();
        $shelter_id = $request->shelter;

        return view('shelter.shelter_accomodation.create', compact('shelter_id', 'accomodation_shelter', 'accomodation_place'));
    }

    public function storeAccomodationBox(ShelterAccomodationBoxRequest $request)
    {
        $accomodation_type = ShelterAccomodationType::findOrFail($request->accomodation_box_type);

        $shelter_accomodation = ShelterAccomodation::create([
            'shelter_id' => $request->shelter_id,
            'shelter_accomodation_type_id' => $accomodation_type->id,
            'name' => $request->accomodation_box_name,
            'dimensions' => $request->accomodation_box_size,
            'description' => $request->accomodation_box_desc
        ]);

        if ($request->hasFile('accomodation_box_photo')) {
            foreach ($request->file('accomodation_box_photo') as $image) {
                $shelter_accomodation->addMedia($image)->toMediaCollection('accomodation-photos');
            }
        }
        $accomodation_type->shelterAccomodation()->save($shelter_accomodation);

        return redirect()->route('shelter_accomodation', ['shelter_id' => $request->shelter_id, 'shelter' => $request->shelter_id])->with('msg', 'Uspješno dodano.');
    }

    public function storeAccomodationPlace(ShelterAccomodationPlaceRequest $request)
    {

        $accomodation_type = ShelterAccomodationType::findOrFail($request->accomodation_place_type);
        $shelter_id = $request->shelter_id;

        $shelter_accomodation = ShelterAccomodation::create([
            'shelter_id' => $request->shelter_id,
            'shelter_accomodation_type_id' => $accomodation_type->id,
            'name' => $request->accomodation_place_name,
            'dimensions' => $request->accomodation_place_size,
            'description' => $request->accomodation_place_desc
        ]);
        $accomodation_type->shelterAccomodation()->save($shelter_accomodation);

        if ($request->hasFile('accomodation_place_photo')) {
            foreach ($request->file('accomodation_place_photo') as $image) {
                $shelter_accomodation->addMedia($image)->toMediaCollection('accomodation-photos');
            }
        }
        $accomodation_type->shelterAccomodation()->save($shelter_accomodation);


        return redirect()->route('shelter_accomodation', ['shelter_id' => $shelter_id, 'shelter' => $shelter_id])->with('msg', 'Uspješno dodano.');
    }

    public function editAccomodation($id)
    {

        $shelterAccomodationItem = ShelterAccomodation::where('id', $id)->get();
        $returnHTML = view('shelter.shelter_accomodation._update', ['shelterAccomodationItem' => $shelterAccomodationItem])->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


    public function updateAccomodation(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'accomodation_name' => 'required',
            'accomodation_size' => 'required',
            'accomodation_desc' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $shelter_accomodation = ShelterAccomodation::find($id)->update([
            'accomodation_name' => $request->accomodation_name,
            'accomodation_size' => $request->accomodation_size,
            'accomodation_desc' => $request->accomodation_size
        ]);

        if ($request->hasFile('accomodation_photos')) {
            foreach ($request->file('accomodation_photos') as $image) {
                $shelter_accomodation->addMedia($image)->toMediaCollection('accomodation-photos');
            }
        }
        return response()->json(['success' => 'Smještajna jedinica uspješno spremljena.']);
    }
}
