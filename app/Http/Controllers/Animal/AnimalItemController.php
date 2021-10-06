<?php

namespace App\Http\Controllers\Animal;

use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalData;
use App\Models\Animal\AnimalFile;
use App\Models\Animal\AnimalItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalItemFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AnimalItemFilePostRequest;

class AnimalItemController extends Controller
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $animalItems = AnimalItem::find($id);
        $animalFiles = AnimalFile::where('shelter_code', $animalItems->shelter_code)->get();
        
        $mediaFiles = $animalFiles->each(function($item, $key){
            $item->getMedia('media');
        });

        $animalItemsMedia = $animalItems->getMedia('media');

        return view('animal.animal_item.info', [
            'animalItems' => $animalItems,
            'animalItemsMedia' => $animalItemsMedia,
            'mediaFiles' => $mediaFiles,
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
        $animalItem = AnimalItem::findOrFail($id);
        $mediaItems = $animalItem->getMedia('media');
        $size = $animalItem->animal->animalSize;

        return view('animal.animal_item.edit', [
            'animalItem' => $animalItem,
            'mediaItems' => $mediaItems,
            'size' => $size,
        ]); 
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
        $animalItem = AnimalItem::findOrFail($id);
        $animalItem->animal_size_attributes_id = $request->animal_size_attributes_id;
        $animalItem->animal_dob = $request->animal_dob;
        $animalItem->animal_gender = $request->animal_gender;
        $animalItem->location = $request->location;
        $animalItem->save();

        return redirect('/shelter/'.$animalItem->shelter_id.'/animal/'.$animalItem->shelter_code)->with('msg', 'Uspješno ažurirano.');
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

    public function file(AnimalItemFilePostRequest $request)
    {
        $animalItemFile = AnimalItem::find($request->animal_item_id);
        $animalItemFile->addMedia($request->filenames)->toMediaCollection('media');

        return redirect('/animal_item/'.$request->animal_item_id.'/edit')->with('msg', 'Uspješno dodan dokument');
    }

    public function getId($id)
    {
        $animalItems = AnimalItem::find($id);

        return response()->json($animalItems);
    }

    public function changeShelter(Request $request, $id)
    {
        //Increment ID
        $incrementId = DB::table('animal_shelter')->orderBy('id', 'DESC')->first();
        if(empty($incrementId->id)){
            $increment = 1;
        }
        else {
            $increment = $incrementId->id + 1;
        }
        
        // Promjena statusa kod trenutne životinje
        $animalItem = AnimalItem::findOrFail($id);
        $animalItem->status = 0;
        $animalItem->save();

        // ID od sheltera kojem je pripadala životinja
        $shelterID = $animalItem->shelter_id;

        $shelter = Shelter::find($request->shelter_id);
        
        // Umanjenje količine za 1
        $shelter->animals()
        ->newPivotStatement()
        ->where('animal_id', '=', $request->animal_id)
        ->where('shelter_code', '=', $request->shelter_code)
        ->decrement('quantity', 1);

        // Dodavanje životinje u novi šelter sa novom šifrom
        $shelter->animals()->attach($id, [
            'shelter_id' => $request->shelter_id,
            'animal_id' => $request->animal_id,
            'shelter_code' => Carbon::now()->format('Y') .''. $shelter->shelter_code .'-'. $increment,
            'quantity' => 1,
        ]);

        // Kopija životinje u novi šelter
        $copy = $animalItem->replicate();
        $copy->status = 1;
        $copy->shelter_id = $request->shelter_id;
        $copy->shelter_code = Carbon::now()->format('Y') .''. $shelter->shelter_code .'-'. $increment;
        $copy->save();
        
        return redirect('/shelter/'.$shelterID)->with('msg', 'Uspješno premješteno u oporavilište '.$shelter->name.'');
    }

    public function generatePDF($id)
    {
        $animalItems = AnimalItem::with('animal', 'shelter')->find($id);
        $animalFiles = AnimalFile::where('shelter_code', $animalItems->shelter_code)->get();
        
        $mediaFiles = $animalFiles->each(function($item, $key){
            $item->getMedia('media');
        });
        
        $pdf = PDF::loadView('myPDF', compact('animalItems', 'mediaFiles'));
    
        return $pdf->stream('my.pdf');
    }
}
