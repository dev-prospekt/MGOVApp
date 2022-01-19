<?php

namespace App\Http\Controllers\Animal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Animal\AnimalItem;
use App\Models\ShelterAnimalPrice;
use App\Http\Controllers\Controller;

class AnimalItemPriceController extends Controller
{
    public function __construct($animalItem = null)
    {
        $this->animalItem = $animalItem;
    }

    // Ako bude potrebno napraviti update cijene
    // kada se promijeni dob
    public function updateDob()
    {
        // JUV - 30% veća cijena
        // Za ostale se ne računa 30%
        $animalItem = $this->animalItem;
        $dateNow = Carbon::now();
        
        dd($animalItem);
    }

    public function updateDateAndPrice(Request $request, $id)
    {
        $animalItem = AnimalItem::findOrFail($id);

        if (empty($animalItem->dateRange->end_date)) { // Samo ako nije završena skrb
            // Date Range
            if (!empty($request->end_date)) {
                $animalItem->dateRange()->update([
                    'end_date' => Carbon::createFromFormat('m/d/Y', $request->end_date)
                ]);

                // Standard
                $from = Carbon::parse($animalItem->dateRange->start_date);
                $to = Carbon::createFromFormat('m/d/Y', $request->end_date);
                $diff_in_days = $to->diffInDays($from);

                // Standardna cijena
                $totalPriceStand = $this->getPrice($animalItem, $diff_in_days);
            }

            // Solitary or Group
            if (!empty($request->solitary_or_group_end) || !empty($request->end_date) || !empty($request->solitary_or_group_type)) {
                // Ako je poslan datum za kraj skrbi, ažurirat cemo samo zadnji record
                // Zadnji record, polje end_date je uvijek null pa cemo ga azuirati i dobiti ukupni broj dana
                if (!empty($request->end_date) && empty($request->solitary_or_group_type) && empty($request->solitary_or_group_end)) {
                    // Ažuriranje zadnjeg recorda koji ima end_date null
                    $animalItem->dateSolitaryGroups()
                        ->where('end_date', '=', null)
                        ->update([
                            'end_date' => Carbon::createFromFormat('m/d/Y', $request->end_date),
                        ]);
                }

                // Ako se posalje samo type (Solitarna, Grupa)
                // Ažuriramo podatak
                if (!empty($request->solitary_or_group_type) && empty($request->solitary_or_group_end) && empty($request->end_date)) {
                    $animalItem->dateSolitaryGroups()
                        ->where('end_date', '=', null)
                        ->update([
                            'solitary_or_group' => $request->solitary_or_group_type,
                        ]);
                }

                // Ovaj dio radi samo ako je poslan zadnji datum kod promjene type-a (Grupa, Solitarna)
                if (!empty($request->solitary_or_group_end) && !empty($request->solitary_or_group_type) && empty($request->end_date)) {
                    // Ažuriranje zadnjeg recorda koji ima end_date null
                    $updateDate = $animalItem->dateSolitaryGroups()
                        ->where('end_date', '=', null)
                        ->update([
                            'end_date' => Carbon::createFromFormat('m/d/Y', $request->solitary_or_group_end),
                        ]);

                    if ($updateDate) {
                        // Novi red i novi type (Grupa, Solitarna)
                        if (!empty($request->solitary_or_group_type)) {
                            $animalItem->dateSolitaryGroups()
                                ->create([
                                    'start_date' => Carbon::createFromFormat('m/d/Y', $request->solitary_or_group_end),
                                    'solitary_or_group' => $request->solitary_or_group_type,
                                ]);
                        }
                    }
                }

                // Izvlacimo sve record-e koji je type isti kao kod animalItem (Grupa, Solitarna)
                // Samo koji imaju datume od do kako bi dobili izracun dana
                $allDateSolitaryOrGroup = $animalItem->dateSolitaryGroups->where('solitary_or_group', '=', $animalItem->solitary_or_group);

                $solitaryOrGroupDays = 0; // Ukupni broj dana
                foreach ($allDateSolitaryOrGroup as $key) { // Izvlacenje svih dana za type u kojem je animalItem trenutno
                    $from = Carbon::parse($key->start_date);
                    $to = (isset($key->end_date)) ? Carbon::parse($key->end_date) : '';
                    $solitaryOrGroupDiffDays = $to->diffInDays($from);

                    $solitaryOrGroupDays += $solitaryOrGroupDiffDays;
                }

                // Cijena
                $totalPriceSolitaryOrGroup = $this->getPrice($animalItem, $solitaryOrGroupDays);
            }

            // Hibern
            if (!empty($request->hib_est_from) || !empty($request->end_date)) {

                // Spremamo početak hibernacije
                if (!empty($request->hib_est_from) && empty($request->end_date)) {
                    $animalItem->dateRange()->update([
                        'hibern_start' => (isset($request->hib_est_from)) ? Carbon::createFromFormat('m/d/Y', $request->hib_est_from) : null,
                    ]);
                }

                // Ako je poslan datum za kraj skrbi, ažuriraj ako je hibern_end prazan
                if (empty($animalItem->dateRange->hibern_end)) {
                    if (!empty($request->end_date) && !empty($animalItem->dateRange->hibern_start)) {
                        $updateAnimalItemHibern = $animalItem->dateRange()->update([
                            'hibern_end' => (isset($request->end_date)) ? Carbon::createFromFormat('m/d/Y', $request->end_date) : null
                        ]);
                    }
                }

                // update hibernacije - spremamo kraj hibernacije
                if (!empty($request->hib_est_to)) {
                    $animalItem->dateRange()->update([
                        'hibern_start' => Carbon::createFromFormat('m/d/Y', $request->hib_est_from),
                        'hibern_end' => Carbon::createFromFormat('m/d/Y', $request->hib_est_to),
                    ]);
                }

                // Izvlacimo cijenu hibernacije
                if (!empty($request->end_date) && !empty($animalItem->dateRange->hibern_start)) {
                    if (!empty($diff_in_days)) {
                        // Ako je hibernacija ispunjena
                        if(!empty($animalItem->dateRange->hibern_start) && !empty($animalItem->dateRange->hibern_end)){
                            if (!empty($diff_in_days)) {
                                $hib_from = Carbon::parse($animalItem->dateRange->hibern_start);
                                $hib_to = Carbon::parse($animalItem->dateRange->hibern_end);
                                $hib_diff_days = $hib_to->diffInDays($hib_from);

                                $hib_day = ((int)$diff_in_days - (int)$hib_diff_days);

                                // Cijena za hibernaciju
                                $totalPriceHibern = $this->getPrice($animalItem, $hib_day);
                            }
                        }
                        else {
                            $hib_from = Carbon::parse($animalItem->dateRange->hibern_start);
                            $hib_to = Carbon::createFromFormat('m/d/Y', $request->end_date);
                            $hib_diff_days = $hib_to->diffInDays($hib_from);
    
                            $hib_day = ((int)$diff_in_days - (int)$hib_diff_days);
    
                            // Cijena za hibernaciju
                            $totalPriceHibern = $this->getPrice($animalItem, $hib_day);
                        }
                    }
                }
            }

            // Kada se salje zavrsetak skrbi
            // Trebamo imati i početni datum proširene skrbi
            $startDateFull = $animalItem->dateFullCare()->where('end_date', '=', null)->latest()->take(1)->first();
            // Proširena skrb
            if (!empty($request->full_care_start)) {
                $full_care_from = Carbon::createFromFormat('m/d/Y', $request->full_care_start);
                $full_care_to = (isset($request->full_care_end)) ? Carbon::createFromFormat('m/d/Y', $request->full_care_end) : '';

                if (!empty($full_care_from) && empty($full_care_to)) {
                    if (!empty($animalItem->dateFullCare->first())) {
                        $update = $animalItem->dateFullCare()->where('end_date', '=', null)->latest()->take(1)->first();

                        if (!empty($update)) {
                            $animalItem->dateFullCare()->where('end_date', '=', null)->update([
                                'start_date' => $full_care_from,
                            ]);
                        } else {
                            $animalItem->dateFullCare()->where('end_date', '!=', null)->create([
                                'start_date' => $full_care_from,
                            ]);
                        }
                    } else {
                        $animalItem->dateFullCare()->create([
                            'start_date' => $full_care_from,
                        ]);
                    }
                }

                if (!empty($full_care_from) && !empty($full_care_to)) {
                    $full_care_diff_in_days = $full_care_to->diffInDays($full_care_from);

                    $fullCaretotaldays = 0;
                    foreach ($animalItem->dateFullCare as $key) {
                        $fullCaretotaldays += $key->days;
                    }

                    if ($fullCaretotaldays >= 10 || ($fullCaretotaldays + $full_care_diff_in_days) > 10) {
                        return redirect()->back()->with('error', 'Proširena skrb ne smije biti duža od 10 dana.');
                        die();
                    }
                    if ($full_care_diff_in_days > 10) {
                        return redirect()->back()->with('error', 'Proširena skrb ne smije biti duža od 10 dana.');
                        die();
                    }

                    $update = $animalItem->dateFullCare()->where('end_date', '=', null)->latest()->take(1)->first();

                    if (!empty($update)) {
                        $animalItem->dateFullCare()->update([
                            'start_date' => $full_care_from,
                            'end_date' => $full_care_to,
                            'days' => $full_care_diff_in_days,
                        ]);
                    } else {
                        $animalItem->dateFullCare()->create([
                            'start_date' => $full_care_from,
                            'end_date' => $full_care_to,
                            'days' => $full_care_diff_in_days,
                        ]);
                    }

                    // Cijena za proširenu skrb
                    $totalPriceFullCare = $this->getPrice($animalItem, ($fullCaretotaldays + $full_care_diff_in_days), 'fullCare');
                }
            } 
            elseif (!empty($startDateFull->start_date) && !empty($request->end_date)) {
                $full_care_from = Carbon::parse($startDateFull->start_date);
                $full_care_to = (isset($request->end_date)) ? Carbon::createFromFormat('m/d/Y', $request->end_date) : '';
                $full_care_diff_in_days = $full_care_to->diffInDays($full_care_from);

                $fullCaretotaldays = 0;
                foreach ($animalItem->dateFullCare as $key) {
                    $fullCaretotaldays += $key->days;
                }

                if ($fullCaretotaldays >= 10 || ($fullCaretotaldays + $full_care_diff_in_days) > 10) {
                    return redirect()->back()->with('error', 'Proširena skrb ne smije biti duža od 10 dana.');
                    die();
                }
                if ($full_care_diff_in_days > 10) {
                    return redirect()->back()->with('error', 'Proširena skrb ne smije biti duža od 10 dana.');
                    die();
                }

                $animalItem->dateFullCare()->where('end_date', '=', null)->update([
                    'start_date' => $full_care_from,
                    'end_date' => $full_care_to,
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

            // solitary_or_group - kod svake akcije treba napraviti update cijene
            if (!empty($request->solitary_or_group_end) || !empty($request->end_date) || !empty($request->solitary_or_group_type)) {
                $totalPriceSolitaryOrGroup = (isset($totalPriceSolitaryOrGroup)) ? $totalPriceSolitaryOrGroup : null;

                $this->updatePriceSolitaryOrGroup($animalItem->id, $totalPriceSolitaryOrGroup);

                // Nakon što je poslano sve za izracun cijene
                // ažuriramo animalItem - Grupa ili Solitarno
                if (!empty($request->solitary_or_group_type)) { // Provjera je li postoji type
                    AnimalItem::where('id', $id)->update(['solitary_or_group' => $request->solitary_or_group_type]);
                }
            }

            // Update svih cijena nakon zavrsetka skrbi
            if (!empty($request->end_date)) {

                // update statusa
                AnimalItem::where('id', $id)->update(['animal_item_care_end_status' => false]);

                $totalPriceHibern = (isset($totalPriceHibern)) ? $totalPriceHibern : null;
                $totalPriceFullCare = (isset($totalPriceFullCare)) ? $totalPriceFullCare : null;
                $totalPriceStand = (isset($totalPriceStand)) ? $totalPriceStand : null;

                $this->updatePrice($animalItem->id, $totalPriceStand, $totalPriceHibern, $totalPriceFullCare);
            }

            // Finish Price
            $euthanasia_price = 0;
            if(!empty($request->euthanasia_type)){
                if ($request->euthanasia_type == 'Izvedeno u oporavilištu') {
                    $euthanasia_price = 100;
                } else {
                    $euthanasia_price = $request->euthanasia_price;
                }
            }

            if (!empty($totalPriceSolitaryOrGroup)) {
                $solitaryAndGroupPrice = $animalItem->shelterAnimalPrice;

                if (!empty($solitaryAndGroupPrice->group_price)) {
                    if (isset($totalPriceHibern)) {
                        if ($request->end_care_type == 3) {
                            $sol_group = ($solitaryAndGroupPrice->group_price + $solitaryAndGroupPrice->solitary_price);
                            $finishPrice = ($sol_group + $euthanasia_price + $totalPriceHibern);
                        }
                        else {
                            $finishPrice = $totalPriceHibern;
                        }
                    } 
                    else {
                        if ($solitaryAndGroupPrice->full_care != 0) {
                            $sol_group = ($solitaryAndGroupPrice->group_price + $solitaryAndGroupPrice->solitary_price);
                            $finishPrice = ($solitaryAndGroupPrice->full_care + $sol_group + $euthanasia_price);
                        } 
                        elseif ($request->end_care_type == 3) {
                            $sol_group = ($solitaryAndGroupPrice->group_price + $solitaryAndGroupPrice->solitary_price);
                            $finishPrice = ($sol_group + $euthanasia_price);
                        } 
                        else {
                            $finishPrice = ($solitaryAndGroupPrice->group_price + $solitaryAndGroupPrice->solitary_price);
                        }
                    }
                }

                if (!empty($solitaryAndGroupPrice->solitary_price)) {
                    if (isset($totalPriceHibern)) {
                        if ($request->end_care_type == 3) {
                            $sol_group = ($solitaryAndGroupPrice->group_price + $solitaryAndGroupPrice->solitary_price);
                            $finishPrice = ($sol_group + $euthanasia_price + $totalPriceHibern);
                        }
                        else {
                            $finishPrice = $totalPriceHibern;
                        }
                    } 
                    else {
                        if ($solitaryAndGroupPrice->full_care != 0) {
                            $sol_group = ($solitaryAndGroupPrice->group_price + $solitaryAndGroupPrice->solitary_price);
                            $finishPrice = ($solitaryAndGroupPrice->full_care + $sol_group + $euthanasia_price);
                        } elseif ($request->end_care_type == 3) {
                            $sol_group = ($solitaryAndGroupPrice->group_price + $solitaryAndGroupPrice->solitary_price);
                            $finishPrice = ($sol_group + $euthanasia_price);
                        } else {
                            $finishPrice = ($solitaryAndGroupPrice->group_price + $solitaryAndGroupPrice->solitary_price);
                        }
                    }
                }

                $this->updateFinishPrice($animalItem->id, $finishPrice);
            }

            // END
            if ($request->end_care_type) {
                if (!empty($animalItem->careEnd)) {
                    $animalItem->careEnd()->update([
                        'animal_item_care_end_type_id' => $request->end_care_type,
                        'release_location' => $request->release_location,
                        'permanent_keep_name' => $request->permanent_keep_name,
                        'care_end_other' => $request->care_end_other,
                        'care_end_description' => $request->care_end_description
                    ]);
                } else {
                    $animalItem->careEnd()->create([
                        'animal_item_care_end_type_id' => $request->end_care_type,
                        'release_location' => $request->release_location,
                        'permanent_keep_name' => $request->permanent_keep_name,
                        'care_end_other' => $request->care_end_other,
                        'care_end_description' => $request->care_end_description
                    ]);
                }

                if ($request->end_care_type == 3) { // Usmrcivanje
                    if (!empty($animalItem->euthanasia)) {
                        $animalItem->euthanasia()->update([
                            'shelter_staff_id' => $request->vetenaryStaff,
                            'price' => $euthanasia_price,
                        ]);
                    } else {
                        $euth = $animalItem->euthanasia()->create([
                            'shelter_staff_id' => $request->vetenaryStaff,
                            'price' => $euthanasia_price,
                        ]);
                        // Eutanazija Račun
                        if (!empty($request->euthanasia_invoice)) {
                            $euth->addMedia($request->euthanasia_invoice)->toMediaCollection('euthanasia_invoice');
                        }
                    }
                }
            }

            return redirect()->back()->with('msg_update', 'Uspješno ažurirano.');
        } else {
            return redirect()->route('shelters.animal_groups.animal_items.show', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem])
                ->with('care_end', 'Za ovu jedinku je skrb završena i ne možete je ažurirati.');
        }
    }

    public function getPrice($animalItem, $diff_in_days, $full_care = null)
    {
        if($animalItem->animal->animalType->first()->type_code != 'IJ'){
            if ($animalItem->solitary_or_group == 'Grupa') { // U grupi je
                $groupPrice = $animalItem->animalSizeAttributes->group_price;
                $totalPrice = ($diff_in_days * $groupPrice);
            } else { // Nije u grupi
                $basePrice = $animalItem->animalSizeAttributes->base_price;
                $totalPrice = ($diff_in_days * $basePrice);
            }
        }
        else {
            $totalPrice = 0;
        }

        // Juvenilne jedinke - Ako su gmazovi cijena nema razlike
        if ($animalItem->animal_age == 'JUV(juvenilna)') {
            if ($animalItem->animal->animalCategory->animalSystemCategory->name != 'gmazovi') {
                $percentGet = 30;
                $percentDecimal = $percentGet / 100;
                $totalWithPercent = ($totalPrice * $percentDecimal);
                $totalPrice = ($totalPrice + $totalWithPercent);
                $totalPrice = $totalPrice;
            }
        }

        // Proširena skrb
        if (!empty($full_care)) {
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

        if (!empty($totalPriceSolitaryOrGroup)) {
            if ($animalItem->solitary_or_group == 'Grupa') {
                if (!empty($shelterAnimalPrice)) {
                    $animalItem->shelterAnimalPrice()->update([
                        'animal_item_id' => $animalId,
                        'group_price' => $totalPriceSolitaryOrGroup
                    ]);
                } else {
                    $animalItem->shelterAnimalPrice()->create([
                        'animal_item_id' => $animalId,
                        'group_price' => $totalPriceSolitaryOrGroup
                    ]);
                }
            } else {
                if (!empty($shelterAnimalPrice)) {
                    $animalItem->shelterAnimalPrice()->update([
                        'animal_item_id' => $animalId,
                        'solitary_price' => $totalPriceSolitaryOrGroup
                    ]);
                } else {
                    $animalItem->shelterAnimalPrice()->create([
                        'animal_item_id' => $animalId,
                        'solitary_price' => $totalPriceSolitaryOrGroup
                    ]);
                }
            }
        }
    }

    public function updateFinishPrice($animalId, $totalPrice)
    {
        $shelterAnimalPrice = ShelterAnimalPrice::where('animal_item_id', $animalId)->first();
        $shelterAnimalPrice->update([
            "total_price" => $totalPrice,
        ]);
    }

    public function updatePrice($animalId, $standPrice, $hibernPrice, $fullCarePrice)
    {
        // Create or Update Price
        $shelterAnimalPrice = ShelterAnimalPrice::where('animal_item_id', $animalId)->first();

        if (!empty($shelterAnimalPrice)) {
            $shelterAnimalPrice->update([
                "hibern" => $hibernPrice,
                "full_care" => $fullCarePrice,
            ]);
        } else {
            ShelterAnimalPrice::create([
                "animal_item_id" => $animalId,
                "hibern" => $hibernPrice,
                "full_care" => $fullCarePrice,
            ]);
        }
    }
}
