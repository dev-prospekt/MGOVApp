<?php

namespace App\Http\Controllers\Animal;

use Carbon\Carbon;
use App\Models\DateRange;
use App\Models\FounderData;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use CreateAnimalMarkTypesTable;
use App\Models\Animal\AnimalCode;
use App\Models\Animal\AnimalFile;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalSize;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalMarkType;
use App\Http\Requests\AnimalPostRequest;
use Database\Seeders\AnimalMarkTypeSeeder;
use App\Models\Animal\AnimalSystemCategory;
use BayAreaWebPro\MultiStepForms\MultiStepForm as Form;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $animals = Animal::with('animalType', 'animalCodes', 'animalCategory')->get();

        return view('animal.animal.index', compact('animals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // auth()->user()->shelter->id
        $founder = FounderData::all();
        $shelter = Shelter::find(auth()->user()->shelter->id);
        $sysCats = $shelter->animalSystemCategory;
        $shelterType = $shelter->shelterTypes;
        $markTypes = AnimalMarkType::all();

        $pluckCat = $sysCats->pluck('id');
        $pluckTyp = $shelterType->pluck('code');

        $type = Animal::whereHas('animalType', function ($q) use ($pluckTyp) {
            $q->whereIn('type_code', $pluckTyp);
        })
            ->whereHas('animalCategory.animalSystemCategory', function ($q) use ($pluckCat) {
                $q->whereIn('id', $pluckCat);
            })
            ->orderBy('name')
            ->get();

        return view('animal.animal.create', [
            'typeArray' => $type,
            'founder' => $founder,
            'markTypes' => $markTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnimalPostRequest $request)
    {
        dd($request);
        
        $animals = new Animal;
        $count = $request->quantity;

        // Increment ID
        $incrementId = DB::table('animal_shelter')->orderBy('id', 'DESC')->first();
        if (empty($incrementId->id)) {
            $increment = 1;
        } else {
            $increment = $incrementId->id + 1;
        }

        // Animal ID
        foreach ($request->animal_id as $key) {
            if (!empty($key)) {
                $animal_id = $key;
            }
        }

        // Pivot table
        $animals->shelters()->attach($animal_id, [
            'shelter_id' => $request->shelter_id,
            'animal_id' => $animal_id,
            'shelter_code' => Carbon::now()->format('Y') . '' . $request->shelter_code . '-' . $increment,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        // Pivot id (animal_shelter)
        $pivot_id = Animal::find($animal_id)->shelters()->orderBy('pivot_id', 'desc')->first();

        // Create AnimalFile
        $animalFiles = new AnimalFile;
        $animalFiles->animal_shelter_id = $pivot_id->pivot->id; // ID pivot table animal_shelter
        $animalFiles->shelter_code = Carbon::now()->format('Y') . '' . $request->shelter_code . '-' . $increment; // shelter_code
        $animalFiles->save();

        // Save documents
        if ($request->documents) {
            $animalFiles->addMultipleMediaFromRequest(['documents'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('media');
                });
        }
        if ($request->status_receiving_file) {
            $animalFiles->addMultipleMediaFromRequest(['status_receiving_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('status_receiving_file');
                });
        }
        if ($request->status_found_file) {
            $animalFiles->addMultipleMediaFromRequest(['status_found_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('status_found_file');
                });
        }
        if ($request->reason_file) {
            $animalFiles->addMultipleMediaFromRequest(['reason_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('reason_file');
                });
        }

        // Create AnimalItem
        for ($i = 0; $i < $count; $i++) {
            $animalItem = new AnimalItem;
            $animalItem->animal_id = $animal_id;
            $animalItem->shelter_id = $request->shelter_id;
            $animalItem->animal_file_id = $animalFiles->id;

            if ($count != 1) {
                $animalItem->solitary_or_group = 1;
            } else {
                $animalItem->solitary_or_group = 0;
            }

            $animalItem->reason = $request->reason;
            $animalItem->shelter_code = Carbon::now()->format('Y') . '' . $request->shelter_code . '-' . $increment;
            $animalItem->status = 1;
            $animalItem->status_receiving = $request->status_receiving;
            $animalItem->status_found = $request->status_found;
            $animalItem->founder_id = $request->founder_id;
            $animalItem->location = $request->location;

            // new items in request
            $animalItem->animal_gender = $request->animal_gender;
            $animalItem->animal_dob = $request->animal_dob;
            $animalItem->animal_mark_id = $request->animal_mark;


            $animalItem->date_found = Carbon::createFromFormat('m/d/Y', $request->date_found)->format('d.m.Y');
            $animalItem->save();

            // Date Range
            if (!empty($request->start_date)) {
                $date_range = new DateRange;
                $date_range->animal_item_id = $animalItem->id;
                $date_range->start_date = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('d.m.Y');
                if ($request->hib_est == 'da') {
                    $date_range->hibern_start = Carbon::createFromFormat('m/d/Y', $request->hibern_start)->format('d.m.Y');
                }
                $date_range->save();
            }
        }

        return redirect()->route('shelter.show', $request->shelter_id)->with('msg', 'Uspješno dodano.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $animal = Animal::with('animalCodes', 'animalCategory', 'animalAttributes', 'animalItems', 'shelters')->findOrFail($id);

        return view('animal.animal_item.show', [
            'animal' => $animal,
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
        $animal = Animal::find($id);

        return view('animal.animal.edit')->with('animals', $animal);
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

    public function getBySize(Request $request)
    {
        if (!$request->animal_id) {
            $html = '<option value=""></option>';
        } else {
            $html = '';
            $animalSelect = Animal::with('animalSize')->where('id', $request->animal_id)->first();

            foreach ($animalSelect->animalSize->sizeAttributes as $size) {
                $html .= '<option value="' . $size->id . '">' . $size->name . '</option>';
            }
        }

        return response()->json(['html' => $html]);
    }
}
