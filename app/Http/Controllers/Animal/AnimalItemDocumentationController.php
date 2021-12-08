<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalMark;
use App\Models\Animal\AnimalGroup;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalMarkType;
use Illuminate\Support\Facades\Validator;
use App\Models\Animal\AnimalItemDocumentation;
use App\Http\Requests\DocumentationStoreRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Animal\AnimalItemDocumentationStateType;

class AnimalItemDocumentationController extends Controller
{

    public function index(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
    {
        return view('animal.animal_item_documentation.index', ['shelter' => $shelter, 'animalGroup' => $animalGroup, 'animalItem' => $animalItem]);
    }

    public function create(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
    {
        $markTypes = AnimalMarkType::all();
        $stateTypes = AnimalItemDocumentationStateType::all();

        return view('animal.animal_item_documentation.create', ['shelter' => $shelter, 'animalGroup' => $animalGroup, 'animalItem' => $animalItem, 'markTypes' => $markTypes, 'stateTypes' => $stateTypes]);
    }

    public function store(Request $request, Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
    {

        $itemDocumentation = new AnimalItemDocumentation;
        $itemDocumentation->animal_item_id = $animalItem->id;
        $itemDocumentation->state_recive = $request->state_recive;
        $itemDocumentation->state_recive_desc = $request->state_recive_desc;
        $itemDocumentation->state_found = $request->state_found;
        $itemDocumentation->state_found_desc = $request->state_found_desc;
        $itemDocumentation->state_reason = $request->state_reason;
        $itemDocumentation->state_reason_desc = $request->state_reason_desc;
        $itemDocumentation->save();

        // docs
        if ($request->state_receive_file) {
            $itemDocumentation->addMultipleMediaFromRequest(['state_receive_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('state_receive_file');
                });
        }

        if ($request->state_found_file) {
            $itemDocumentation->addMultipleMediaFromRequest(['state_found_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('state_found_file');
                });
        }

        if ($request->state_reason_file) {
            $itemDocumentation->addMultipleMediaFromRequest(['state_reason_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('state_reason_file');
                });
        }
        // animal Mark
        $animalMark = new AnimalMark;
        $animalMark->animal_mark_type_id = $request->animal_mark;
        $animalMark->animal_item_documentation_id = $itemDocumentation->id;
        $animalMark->animal_mark_note = $request->animal_mark_note;
        $animalMark->save();
        //mark photo
        if ($request->animal_mark_photos) {
            $itemDocumentation->addMultipleMediaFromRequest(['animal_mark_photos'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('animal_mark_photos');
                });
        }


        return redirect()->route(
            'shelters.animal_groups.animal_items.animal_item_documentations.index',
            [$shelter, $animalGroup, $animalItem]
        )->with('store_docs', 'Dokumentacija uspješno spremljena');
    }

    public function edit(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem, AnimalItemDocumentation $animalItemDocumentation)
    {
        $itemDocumentation = AnimalItemDocumentation::find($animalItemDocumentation->id);
        $markTypes = AnimalMarkType::all();
        
        $selectedType = $animalItem->animalDocumentation->animalMark;
        $selectedState = $itemDocumentation->state_found;

        return view('animal.animal_item_documentation.edit', [
            'shelter' => $shelter, 
            'animalGroup' => $animalGroup, 
            'animalItem' => $animalItem,
            'itemDocumentation' => $itemDocumentation, 
            'selectedState' => $selectedState, 
            'markTypes' => $markTypes, 
            'selectedType' => $selectedType
        ]);
    }

    public function update(Request $request, Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem, AnimalItemDocumentation $animalItemDocumentation)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'state_found_desc' => 'required'
            ],
            [
                'state_found_desc.required' => 'Dodajte opis',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $itemDocumentation = AnimalItemDocumentation::find($animalItemDocumentation->id);
        $itemDocumentation->update([
            'animal_item_id' => $animalItem->id,
            'state_found' => $request->edit_state_found,
            'state_found_desc' => $request->state_found_desc
        ]);

        if ($request->edit_state_found_file) {
            $itemDocumentation->addMultipleMediaFromRequest(['edit_state_found_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('state_found_files');
                });
        }

        return response()->json(['success' => 'Uspješno izmjenjeno.']);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnimalItem $animalItem, AnimalItemDocumentation $animalItemDocumentation)
    {
        $animalItemDocumentation->delete();
        return response()->json(['success' => 'Zapis postupanja uspješno izbrisan.']);
    }

    public function deleteImage($img)
    {
        $media = Media::find($img);
        $media->delete();

        return response()->json(['msg' => 'success']);
    }
}
