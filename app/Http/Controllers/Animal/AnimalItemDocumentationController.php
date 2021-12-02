<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Models\Animal\AnimalItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Animal\AnimalItemDocumentation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AnimalItemDocumentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AnimalItem $animalItem)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(AnimalItem $animalItem)
    {

        return view('animal.animal_item_documentation.create');
    }

    public function createStateFound()
    {

        $returnHTML = view('animal.animal_item_documentation.modal_create_state_found')->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function storeStateFound(Request $request, AnimalItem $animalItem)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'state_found' => 'required',
                'state_found_desc' => 'required'
            ],
            [
                'state_found.required' => 'Obvezno polje',
                'state_found_desc.required' => 'Obvezno polje',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        AnimalItemDocumentation::create([
            'animal_item_id' => $animalItem->id,
            'state_found' => $request->state_found,
            'state_found_desc' => $request->state_found_desc
        ]);

        return response()->json(['success' => 'Uspješno dodano.']);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AnimalItem $animalItem, AnimalItemDocumentation $animalItemDocumentation)
    {
        return view('animal.animal_item_documentation.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AnimalItem $animalItem, AnimalItemDocumentation $animalItemDocumentation)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnimalItem $animalItem, AnimalItemDocumentation $animalItemDocumentation)
    {
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
