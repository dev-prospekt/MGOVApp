<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnimalDataController extends Controller
{
    public function view()
    {
        return view('animal.animal_data.index');
    }

    // Dob životinje
    public function animalAge(Request $request)
    {
        dd($request);
    }

    // Stanje životinje
    public function stateType(Request $request)
    {
        dd($request);

        $stateType = new AnimalItemDocumentationStateType;
        $stateType->name = $request->name;
        $stateType->save();

        return redirect()->back()->with('styte_type_msg', 'uspješno spremljeno');
    }
}
