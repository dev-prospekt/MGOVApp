<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FounderService;
use App\Models\Animal\AnimalDob;
use App\Models\Animal\AnimalSolitaryGroup;
use App\Models\Animal\AnimalItemCareEndType;
use App\Models\Animal\AnimalLocationTakeover;
use App\Models\Animal\AnimalItemDocumentationStateType;

class PodaciController extends Controller
{
    public function index()
    {
        $animalDob = AnimalDob::all();
        $animalSolitaryGroup = AnimalSolitaryGroup::all();
        $founderService = FounderService::all();
        $animalStatus = AnimalItemDocumentationStateType::all();
        $animalItemCareEndType = AnimalItemCareEndType::all();
        $animalLocationTakeover = AnimalLocationTakeover::all();

        return view('podaci.index', [
            'animalDob' => $animalDob,
            'animalSolitaryGroup' => $animalSolitaryGroup,
            'founderService' => $founderService,
            'animalStatus' => $animalStatus,
            'animalItemCareEndType' => $animalItemCareEndType,
            'animalLocationTakeover' => $animalLocationTakeover,
        ]);
    }

    public function animal_dob(Request $request)
    {
        $data = new AnimalDob;
        $data->name = $request->name;
        $data->save();

        return redirect()->back()->with('animalDobMsg', 'Uspješno dodano.');
    }

    public function animal_solitary_group(Request $request)
    {
        $data = new AnimalSolitaryGroup;
        $data->name = $request->name;
        $data->save();

        return redirect()->back()->with('animal_solitary_or_group_msg', 'Uspješno dodano.');
    }

    public function founder_services(Request $request)
    {
        $data = new FounderService;
        $data->name = $request->name;
        $data->save();

        return redirect()->back()->with('founder_services_msg', 'Uspješno dodano.');
    }

    public function animal_status(Request $request)
    {
        $data = new AnimalItemDocumentationStateType;
        $data->name = $request->name;
        $data->save();

        return redirect()->back()->with('animal_status_msg', 'Uspješno dodano.');
    }

    public function animal_care_end_status(Request $request)
    {
        $data = new AnimalItemCareEndType;
        $data->name = $request->name;
        $data->save();

        return redirect()->back()->with('animal_care_end_status_msg', 'Uspješno dodano.');
    }

    public function location_animal_takeover(Request $request)
    {
        $data = new AnimalLocationTakeover;
        $data->name = $request->name;
        $data->save();

        return redirect()->back()->with('location_animal_takeover_msg', 'Uspješno dodano.');
    }
}
