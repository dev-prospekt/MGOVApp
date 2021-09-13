<?php

namespace App\Http\Controllers\Animal;

use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalData;
use App\Models\Animal\AnimalItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalItemFile;
use Illuminate\Support\Facades\Storage;

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

        return view('animal.animal_item.info', [
            'animalItems' => $animalItems,
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

        return view('animal.animal_item.edit')->with('animalItem', $animalItem); 
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
        $animalItem->animal_size = $request->animal_size;
        $animalItem->animal_gender = $request->animal_gender;
        $animalItem->location = $request->location;
        $animalItem->save();

        return redirect('/shelter/'.$animalItem->shelter_id.'/animal/'.$animalItem->shelterCode)->with('msg', 'Uspješno ažurirano.');
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

    public function file(Request $request)
    {
        return $this->upload(
            $request->filenames, 
            $request->animal_item_id,
            $request->file_name,
        );
    }

    private function upload($file, $animal_item_id, $file_name)
    {
        $filenames = Storage::disk('public')->put('files',$file);

        $animalItemFile = new AnimalItemFile;
        $animalItemFile->animal_item_id = $animal_item_id;
        $animalItemFile->filenames = $filenames;
        $animalItemFile->file_name = $file_name;
        $animalItemFile->save();

        if($animalItemFile){
            return response()->json(['msg'=>'success', 'data' => $animalItemFile]);
        }
        else {
            return response()->json(['msg'=>'error']);
        }
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
        ->where('shelterCode', '=', $request->shelterCode)
        ->decrement('quantity', 1);

        // Dodavanje životinje u novi šelter sa novom šifrom
        $shelter->animals()->attach($id, [
            'shelter_id' => $request->shelter_id,
            'animal_id' => $request->animal_id,
            'shelterCode' => Carbon::now()->format('Y') .''. $shelter->shelterCode .'-'. $increment,
            'quantity' => 1,
        ]);

        // Kopija životinje u novi šelter
        $copy = $animalItem->replicate();
        $copy->status = 1;
        $copy->shelter_id = $request->shelter_id;
        $copy->shelterCode = Carbon::now()->format('Y') .''. $shelter->shelterCode .'-'. $increment;
        $copy->save();

        // Kopija dokumenata životinje
        $animalFiles = AnimalItem::find($id)->animalItemsFile;
        foreach ($animalFiles as $key) {
            $copyAnimalFiles = $key->replicate();
            $copyAnimalFiles->animal_item_id = $copy->id;
            $copyAnimalFiles->save();
        }
        
        return redirect('/shelter/'.$shelterID)->with('msg', 'Uspješno premješteno u oporavilište '.$shelter->name.'');
    }

    public function generatePDF($id)
    {
        $animalItems = AnimalItem::with('animal')->find($id);
        
        $pdf = PDF::loadView('myPDF', compact('animalItems'));
    
        return $pdf->stream('my.pdf', array('Attachment' => 0));
        //return $pdf->download('animal.pdf');
    }
}
