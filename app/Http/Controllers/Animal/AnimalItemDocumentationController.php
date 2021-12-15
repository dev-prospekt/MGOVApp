<?php

namespace App\Http\Controllers\Animal;

use App\Models\FounderData;
use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalMark;
use App\Models\Animal\AnimalGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnimalDocumentStoreRequest;
use App\Models\Animal\AnimalMarkType;
use Illuminate\Support\Facades\Validator;
use App\Models\Animal\AnimalItemDocumentation;
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

    public function store(AnimalDocumentStoreRequest $request, Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
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
        if (!empty($itemDocumentation->animalMark)) { // update
            $animalMark = $itemDocumentation->animalMark()->update([
                'animal_mark_type_id' => $request->animal_mark,
                'animal_item_documentation_id' => $itemDocumentation->id,
                'animal_mark_note' => $request->animal_mark_note,
            ]);
        } else { // create
            $animalMark = $itemDocumentation->animalMark()->create([
                'animal_mark_type_id' => $request->animal_mark,
                'animal_item_documentation_id' => $itemDocumentation->id,
                'animal_mark_note' => $request->animal_mark_note,
            ]);
        }
        // animal Mark

        //mark photo
        if ($request->animal_mark_photos) {
            $itemDocumentation->addMultipleMediaFromRequest(['animal_mark_photos'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('animal_mark_photos');
                });
        }

        return redirect()->route(
            'shelters.animal_groups.animal_items.animal_item_documentations.index',
            [$shelter,  $animalGroup, $animalItem]
        )->with('store_docs', 'Dokumentacija uspješno spremljena');
    }

    public function edit(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem, AnimalItemDocumentation $animalItemDocumentation)
    {
        $itemDocumentation = AnimalItemDocumentation::find($animalItemDocumentation->id);
        $markTypes = AnimalMarkType::all();
        $selectedMark = $animalItemDocumentation->animalMark->animal_mark_type_id ?? '';
        $animalDocType = AnimalItemDocumentationStateType::all();
        $founder = FounderData::all();

        return view('animal.animal_item_documentation.edit', [
            'shelter' => $shelter, 'animalGroup' => $animalGroup, 'animalItem' => $animalItem,
            'itemDocumentation' => $itemDocumentation, 'markTypes' => $markTypes,
            'animalDocType' => $animalDocType,
            'selectedMark' => $selectedMark,
            'founder' => $founder,
        ]);
    }

    public function update(AnimalDocumentStoreRequest $request, Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem, AnimalItemDocumentation $animalItemDocumentation)
    {
        $itemDocumentation = AnimalItemDocumentation::find($animalItemDocumentation->id);
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
        if (!empty($animalItemDocumentation->animalMark)) { // update
            $animalMark = $animalItemDocumentation->animalMark()->update([
                'animal_mark_type_id' => $request->animal_mark,
                'animal_item_documentation_id' => $itemDocumentation->id,
                'animal_mark_note' => $request->animal_mark_note,
            ]);
        } else { // create
            $animalMark = $animalItemDocumentation->animalMark()->create([
                'animal_mark_type_id' => $request->animal_mark,
                'animal_item_documentation_id' => $itemDocumentation->id,
                'animal_mark_note' => $request->animal_mark_note,
            ]);
        }
        // animal Mark

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem, AnimalItemDocumentation $animalItemDocumentation)
    {
        AnimalItemDocumentation::find($animalItemDocumentation->id)->delete();

        return response()->json(['msg' => 'success']);
    }

    public function deleteImage($img)
    {
        $media = Media::find($img);
        $media->delete();

        return response()->json(['msg' => 'success']);
    }
}
