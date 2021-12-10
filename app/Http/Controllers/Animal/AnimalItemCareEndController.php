<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalGroup;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalItemCareEndType;

class AnimalItemCareEndController extends Controller
{
    public function index(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
    {
        $careEndTypes = AnimalItemCareEndType::all();
        $vetenaryStaff = $shelter->shelterStaff()->vetStaff($shelter->id)->last();
        $animalItem = AnimalItem::with('animal', 'animalSizeAttributes', 'dateRange', 'founder')->find($animalItem->id);

        return view('animal.animal_item_care_end.index', ['animalItem' => $animalItem, 'careEndTypes' => $careEndTypes, 'vetenaryStaff' => $vetenaryStaff]);
    }
}
