<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalItemCareEndType;

class AnimalItemCareEndTypeController extends Controller
{
    public function store(Request $request)
    {
        $animalItemCareEndType = new AnimalItemCareEndType;
        $animalItemCareEndType->name = $request->name;
        $animalItemCareEndType->save();

        return redirect()->back()->with('animalItemCareEndTypeMsg', 'Uspješno dodano.');
    }

    public function showModal()
    {
        $returnHTML = view('modals.care_end_type')->render();
        return response()->json( array('success' => true, 'html' => $returnHTML) );
    }
}
