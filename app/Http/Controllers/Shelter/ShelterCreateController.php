<?php

namespace App\Http\Controllers\Shelter;

use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use Illuminate\Support\Facades\DB;
use App\Models\Shelter\ShelterType;
use App\Http\Controllers\Controller;

class ShelterCreateController extends Controller
{
    public function create()
    {
        $shelterType = ShelterType::all();

        //Last shelter ID
        $shelterID = DB::table('shelters')->orderBy('id', 'DESC')->first();
        $shelter = Shelter::with('shelterTypes')->findOrFail($shelterID->id);

        $type = array();
        foreach ($shelter->shelterTypes as $item) {
            foreach ($item->animalSystemCategory as $key) {
                $type[] = $key;
            }
        }

        $type = collect($type)->sortBy('id')->groupBy('name');

        return view("shelter.create", [
            'shelterType' => $shelterType,
            'type' => $type,
        ]);
    }
}
