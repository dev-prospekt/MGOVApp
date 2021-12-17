<?php

namespace App\Http\Controllers\Animal;

use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalGroup;
use App\Http\Controllers\Controller;
use App\Models\Shelter\ShelterStaff;
use App\Models\Animal\AnimalItemCareEndType;

class AnimalItemCareEndController extends Controller
{
    public function index(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
    {
        $careEndTypes = AnimalItemCareEndType::all();
        $vetenaryStaff = $shelter->shelterStaff()->vetStaff($shelter->id)->last();
        $animalItem = AnimalItem::with('animal', 'animalSizeAttributes', 'dateRange', 'founder')->find($animalItem->id);
        $price = (isset($animalItem->shelterAnimalPrice)) ? $animalItem->shelterAnimalPrice : null;
        $date = $animalItem->dateRange;
        $solitaryGroup = $animalItem->dateSolitaryGroups;

        // Hibernacija : Da ili Ne
        $hibern = $animalItem->dateRange->where('animal_item_id', '=', $animalItem->id)
            ->where('hibern_start', '!=', null)
            ->get();

        // Full Care
        $fullCare = $animalItem->dateFullCare;
        $dateFullCare_total = $animalItem->dateFullCare;
        $countDays = 0;
        foreach ($dateFullCare_total as $key) {
            $countDays += $key->days;
        }
        $maxDate = 10;
        $totalDays = ($maxDate - $countDays);

        return view('animal.animal_item_care_end.index', [
            'animalItem' => $animalItem, 'careEndTypes' => $careEndTypes,
            'vetenaryStaff' => $vetenaryStaff, 'price' => $price,
            'hibern' => $hibern,
            'fullCare' => $fullCare,
            'totalDays' => $totalDays, 'date' => $date,
            'solitaryGroup' => $solitaryGroup,
            'shelter' => $shelter
        ]);
    }

    // Get Founder
    public function getVet(Request $request)
    {
        //dd($request);

        if (!$request->staff_id) {
            $html = '<option value="">-----</option>';
        } 
        else {
            $html = '';
            $shelterStaff = ShelterStaff::where('shelter_staff_type_id', $request->staff_id)
                            ->where('shelter_id', $request->shelter_id)
                            ->get();

            $html = '<option value="">-----</option>';
            foreach ($shelterStaff as $item) {
                $html .= '
                <option value="' . $item->id . '">' . $item->name . '</option>
                ';
            }
        }

        return response()->json(['html' => $html]);
    }
}
