<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalGroup;
use App\Http\Controllers\Controller;

class AnimalItemCareEndController extends Controller
{
    public function index(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
    {
        $animalItem = AnimalItem::with('animal', 'animalSizeAttributes', 'dateRange', 'founder')->find($animalItem->id);
        $price = (isset($animalItem->shelterAnimalPrice)) ? $animalItem->shelterAnimalPrice : null;

        return view('animal.animal_item_care_end.index', [
            'animalItem' => $animalItem,
            'price' => $price,
        ]);
    }
}
