<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalGroup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Animal\AnimalItemDocumentation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AnimalItemDocumentationController extends Controller
{

    public function index(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
    {
        return view('animal.animal_item_documentation.index', ['shelter' => $shelter, 'animalGroup' => $animalGroup, 'animalItem' => $animalItem]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    public function createStateFound($id)
    {

        $returnHTML = view('animal.animal_item_documentation.modal_create_state_found', ['item_id' => $id])->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function storeStateFound(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'state_found' => 'required',
                'state_found_desc' => 'required'
            ],
            [
                'state_found.required' => 'Odaberite stanje jedinke',
                'state_found_desc.required' => 'Dodajte opis',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        $itemDocumentation = AnimalItemDocumentation::create([
            'animal_item_id' => $request->animal_item_id,
            'state_found' => $request->state_found,
            'state_found_desc' => $request->state_found_desc
        ]);

        if ($request->state_found_file) {
            $itemDocumentation->addMultipleMediaFromRequest(['state_found_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('state_found_files');
                });
        }

        return response()->json(['success' => 'Uspješno dodano.']);
    }

    public function editStateFound($id)
    {
        $returnHTML = view('animal.animal_item_documentation.modal_edit_state_found', ['item_id' => $id])->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function deleteStateFound($id)
    {
        $itemDocumentation = AnimalItemDocumentation::find($id);
        $itemDocumentation->delete();
        return response()->json(['success' => 'Zapis postupanja uspješno izbrisan.']);
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
