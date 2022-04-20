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

        $model = [
            'spol' => 'AnimalDob',
            'solitary_group' => 'Način držanja',
            'animal_status' => 'Stanje jedinke',
            'location_takeover' => 'Lokacija preuzimanja životinje',
            'animal_care_end_type' => 'Razlog prestanka skrbi'
        ];

        return view('podaci.index', [
            'animalDob' => $animalDob,
            'animalSolitaryGroup' => $animalSolitaryGroup,
            'founderService' => $founderService,
            'animalStatus' => $animalStatus,
            'animalItemCareEndType' => $animalItemCareEndType,
            'animalLocationTakeover' => $animalLocationTakeover,
            'model' => $model,
        ]);
    }

    public function check_model($params)
    {
        switch ($params) {
            case "AnimalDob":
                $data = [
                    'model' => new AnimalDob,
                    'route' => route('podaci-animal-dob'),
                ];
                break;
            case "Način držanja":
                $data = [
                    'model' => new AnimalSolitaryGroup,
                    'route' => route('animal-solitary-group'),
                ];
                break;
            case "Stanje jedinke":
                $data = [
                    'model' => new AnimalItemDocumentationStateType,
                    'route' => route('podaci-animal-status'),
                ];
                break;
            case "Lokacija preuzimanja životinje":
                $data = [
                    'model' => new AnimalLocationTakeover,
                    'route' => route('podaci-location-animal-takeover'),
                ];
                break;
            case "Razlog prestanka skrbi":
                $data = [
                    'model' => new AnimalItemCareEndType,
                    'route' => route('animal-care-end-status'),
                ];
                break;
            default:
                $data = null;
        }

        return $data;
    }

    /**
     * CREATE VIEW
     */
    public function podaci_create($model)
    {
        $checkModel = $this->check_model($model);
        $route = $checkModel['route'];

        $returnHTML = view("podaci.modal.create", [ 'route' => $route ])->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    /**
     * EDIT
     */
    public function podaci_edit($id, $model)
    {
        $checkModel = $this->check_model($model);

        $data = $checkModel['model']->find($id);
        $returnHTML = view("podaci.modal.edit", [ 'data' => $data, 'model' => $model ])->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

     /**
     * UPDATE
     */
    public function podaci_update(Request $request)
    {
        $checkModel = $this->check_model($request->model);

        $data = $checkModel['model']->find($request->data_id);
        $data->name = $request->name;
        $data->save();

        return redirect()->back()->with('message', 'Uspješno ažurirano.');
    }

    /**
     * DELETE
     */
    public function podaci_delete($id, $model)
    {
        $checkModel = $this->check_model($model);

        $data = $checkModel['model']->find($id);
        $data->delete();

        return response()->json(['status' => 'ok', 'message' => 'Uspješno obrisano']);
    }


    /**
     * CREATE
     */
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