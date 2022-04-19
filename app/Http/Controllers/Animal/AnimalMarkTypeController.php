<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalMarkType;

class AnimalMarkTypeController extends Controller
{
    public function store(Request $request)
    {
        $animalMarkType = new AnimalMarkType;
        $animalMarkType->name = $request->name;
        $animalMarkType->desc = $request->desc;
        $animalMarkType->save();

        return redirect()->back()->with('animalMarkTypeMsg', 'Uspješno dodano.');
    }

    public function showModal()
    {
        $returnHTML = view('modals.mark_type')->render();
        return response()->json( array('success' => true, 'html' => $returnHTML) );
    }
}
