<?php

namespace App\Http\Controllers\Animal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Animal\AnimalItem;
use App\Models\ShelterAnimalPrice;
use App\Http\Controllers\Controller;

class AnimalItemPriceController extends Controller
{

    public function updateDateAndPrice(Request $request, $id)
    {
        $animalItem = AnimalItem::findOrFail($id);

        //dd($request);
        
        // Date Range
        if(!empty($request->end_date)){
            $animalItem->dateRange()->update(['animal_item_id' => $id,
                'end_date' => Carbon::createFromFormat('m/d/Y', $request->end_date),
                'reason_date_end' => $request->reason_date_end,
            ]);

            // Standard
            $from = Carbon::parse($animalItem->dateRange->start_date);
            $to = (isset($animalItem->dateRange->end_date)) ? Carbon::parse($animalItem->dateRange->end_date) : '';
            $diff_in_days = $to->diffInDays($from);

            // Standardna cijena
            $totalPriceStand = $this->getPrice($animalItem, $diff_in_days);
        }

        // Solitary or Group
        if(!empty($request->solitary_or_group_end)){

            // Ažuriranje zadnjeg record koji ima end_date null
            $animalItem->dateSolitaryGroups()
            ->where('end_date', '=', null)
            ->update([
                'animal_item_id' => $id,
                'end_date' => Carbon::createFromFormat('m/d/Y', $request->solitary_or_group_end),
            ]);

            // Novi red i novi type
            if(!empty($request->solitary_or_group_type)){
                $animalItem->dateSolitaryGroups()
                ->create([
                    'animal_item_id' => $id,
                    'start_date' => Carbon::createFromFormat('m/d/Y', $request->solitary_or_group_end),
                    'solitary_or_group' => $request->solitary_or_group_type,
                ]);
            }

            $allDateSolitaryOrGroup = $animalItem->dateSolitaryGroups
                                        ->where('end_date', '!=', null)
                                        ->where('solitary_or_group', '=', $animalItem->solitary_or_group);

            $solitaryOrGroupDays = 0;
            foreach ($allDateSolitaryOrGroup as $key) {
                $from = Carbon::parse($key->start_date);
                $to = (isset($key->end_date)) ? Carbon::parse($key->end_date) : '';
                $solitaryOrGroupDiffDays = $to->diffInDays($from);

                $solitaryOrGroupDays += $solitaryOrGroupDiffDays;
            }

            // Cijena ako je solitarna ili u grupi
            $totalPriceSolitaryOrGroup = $this->getPrice($animalItem, $solitaryOrGroupDays);
        }

        // Hibern
        if(!empty($request->hib_est_from)){
            $animalItem->dateRange()->update(['animal_item_id' => $id,
                'hibern_start' => (isset($request->hib_est_from)) ? Carbon::createFromFormat('m/d/Y', $request->hib_est_from) : null,
            ]);

            if(!empty($request->hib_est_to)){
                $animalItem->dateRange()->update(['animal_item_id' => $id,
                    'hibern_start' => Carbon::createFromFormat('m/d/Y', $request->hib_est_from),
                    'hibern_end' => Carbon::createFromFormat('m/d/Y', $request->hib_est_to),
                ]);
                
                if(!empty($diff_in_days)){
                    $hib_from = Carbon::createFromFormat('m/d/Y', $request->hib_est_from);
                    $hib_to = Carbon::createFromFormat('m/d/Y', $request->hib_est_to);
                    $hib_diff_days = $hib_to->diffInDays($hib_from);

                    $hib_day = ((int)$diff_in_days - (int)$hib_diff_days);

                    // Cijena za hibernaciju
                    $totalPriceHibern = $this->getPrice($animalItem, $hib_day);
                }
            }
        }

        // Proširena skrb
        if(!empty($request->full_care_start)){
            $full_care_from = Carbon::createFromFormat('m/d/Y', $request->full_care_start);
            $full_care_to = (isset($request->full_care_end)) ? Carbon::createFromFormat('m/d/Y', $request->full_care_end) : '';
            $full_care_diff_in_days = $full_care_to->diffInDays($full_care_from);

            $fullCaretotaldays = 0;
            foreach ($animalItem->dateFullCare as $key) {
                $fullCaretotaldays += $key->days;
            }
            if($fullCaretotaldays >= 10 || ($fullCaretotaldays + $full_care_diff_in_days) > 10){
                return redirect()->back()->with('error', 'Proširena skrb ne smije biti duža od 10 dana.');
                die();
            }

            if($full_care_diff_in_days > 10){
                return redirect()->back()->with('error', 'Proširena skrb ne smije biti duža od 10 dana.');
                die();
            }

            $animalItem->dateFullCare()->create(['animal_item_id' => $id,
                'start_date' => Carbon::createFromFormat('m/d/Y', $request->full_care_start),
                'end_date' => Carbon::createFromFormat('m/d/Y', $request->full_care_end),
                'days' => $full_care_diff_in_days,
            ]);

            // Cijena za proširenu skrb
            $totalPriceFullCare = $this->getPrice($animalItem, ($fullCaretotaldays + $full_care_diff_in_days), 'fullCare');
        }
        else {
            // Ako ne postoji u requestu datum za proširenu skrb
            // onda nakon update-a cijena bude null
            // zato uzimamo ukupni broj dana ovdje i ažuriramo cijenu sa ukupnim brojem dana.
            $fullCaretotaldays = 0;
            foreach ($animalItem->dateFullCare as $key) {
                $fullCaretotaldays += $key->days;
            }
            // Cijena za proširenu skrb
            $totalPriceFullCare = $this->getPrice($animalItem, $fullCaretotaldays, 'fullCare');
        }

        // kod svake akcije treba napraviti update cijene
        if(!empty($request->solitary_or_group_end)){
            $totalPriceSolitaryOrGroup = (isset($totalPriceSolitaryOrGroup)) ? $totalPriceSolitaryOrGroup : null;
            
            $this->updatePriceSolitaryOrGroup($animalItem->id, $totalPriceSolitaryOrGroup);

            // Nakon što je poslano sve za izracun cijene
            // ažuriramo animalItem - Grupa ili Solitarno
            // Provjera je li postoji type
            if(!empty($request->solitary_or_group_type)){
                $animalItem->solitary_or_group = $request->solitary_or_group_type;
                $animalItem->save();
            }
        }

        // Update svih cijena nakon zavrsetka skrbi
        if(!empty($request->end_date)){
            $totalPriceHibern = (isset($totalPriceHibern)) ? $totalPriceHibern : null;
            $totalPriceFullCare = (isset($totalPriceFullCare)) ? $totalPriceFullCare : null;
            $totalPriceSolitaryOrGroup = (isset($totalPriceSolitaryOrGroup)) ? $totalPriceSolitaryOrGroup : null;

            $this->updatePrice($animalItem->id, $totalPriceStand, $totalPriceHibern, $totalPriceFullCare, $totalPriceSolitaryOrGroup);
        }

        return redirect()->back()->with('msg_update', 'Uspješno ažurirano.');
    }

    public function getPrice($animalItem, $diff_in_days, $full_care = null)
    {
        if($animalItem->solitary_or_group == 'Grupa'){ // U grupi je
            $groupPrice = $animalItem->animalSizeAttributes->group_price;
            $totalPrice = ($diff_in_days * $groupPrice);
        }
        else { // Nije u grupi
            $basePrice = $animalItem->animalSizeAttributes->base_price;
            $totalPrice = ($diff_in_days * $basePrice);
        }

        // Juvenilne jedinke - Ako su gmazovi cijena nema razlike
        if($animalItem->animal_age == 'JUV'){
            if($animalItem->animal->animalCategory->animalSystemCategory != 'gmazovi'){
                $percentGet = 30;
                $percentDecimal = $percentGet / 100;
                $totalWithPercent = ($totalPrice * $percentDecimal);
                $totalPrice = ($totalPrice + $totalWithPercent);
                $totalPrice = $totalPrice;
            }
        }

        // Proširena skrb
        if(!empty($full_care)){
            $full_care_total_price = ($diff_in_days * 200);
            $full_care_total_price = $full_care_total_price;
            $totalPrice = $full_care_total_price;
        }
        
        return $totalPrice;
    }

    public function updatePriceSolitaryOrGroup($animalId, $totalPriceSolitaryOrGroup)
    {
        $shelterAnimalPrice = ShelterAnimalPrice::where('animal_item_id', $animalId)->first();
        $animalItem = AnimalItem::find($animalId);

        if($animalItem->solitary_or_group == 'Grupa'){
            if(!empty($shelterAnimalPrice)){
                $animalItem->shelterAnimalPrice()->update([
                    'animal_item_id' => $animalId,
                    'group_price' => $totalPriceSolitaryOrGroup
                ]);
            }
            else {
                $animalItem->shelterAnimalPrice()->create([
                    'animal_item_id' => $animalId,
                    'group_price' => $totalPriceSolitaryOrGroup
                ]);
            }
        }
        else {
            if(!empty($shelterAnimalPrice)){
                $animalItem->shelterAnimalPrice()->update([
                    'animal_item_id' => $animalId,
                    'solitary_price' => $totalPriceSolitaryOrGroup
                ]);
            }
            else {
                $animalItem->shelterAnimalPrice()->create([
                    'animal_item_id' => $animalId,
                    'solitary_price' => $totalPriceSolitaryOrGroup
                ]);
            }
        }

    }

    public function updatePrice($animalId, $standPrice, $hibernPrice, $fullCarePrice, $totalPriceSolitaryOrGroup = null)
    {
        // Create or Update Price
        $shelterAnimalPrice = ShelterAnimalPrice::where('animal_item_id', $animalId)->first();

        if(!empty($shelterAnimalPrice)){
            $shelterAnimalPrice->update([
                "hibern" => $hibernPrice,
                "full_care" => $fullCarePrice,
                "stand_care" => $standPrice,
            ]);
        }
        else {
            ShelterAnimalPrice::create([
                "animal_item_id" => $animalId,
                "hibern" => $hibernPrice,
                "full_care" => $fullCarePrice,
                "stand_care" => $standPrice,
            ]);
        }
    }
}
