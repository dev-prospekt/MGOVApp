<?php

namespace App\Http\Controllers\Shelter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShelterAccomodationController extends Controller
{
    public function index(Request $request)
    {
        $shelter_id = $request->shelter;
        return view('shelter.shelter_accomodation.index', compact('shelter_id'));
    }

    public function create()
    {


        $returnHTML = view('shelter.shelter_accomodation._create')->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}
