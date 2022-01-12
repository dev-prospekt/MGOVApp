<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Exports\ZnsExport;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Animal\AnimalCategory;
use App\Models\Animal\AnimalItemCareEndType;

class ReportController extends Controller
{
    public function viewReports()
    {
        $animals = Animal::all();
        $animalCategory = AnimalCategory::all();
        $shelters = Shelter::all();
        $endCareType = AnimalItemCareEndType::all();

        return view('reports.index', [
            'animals' => $animals,
            'shelters' => $shelters,
            'endCareType' => $endCareType,
            'animalCategory' => $animalCategory,
        ]);
    }

    public function generateZNS(Request $request)
    {
        $shelter = Shelter::find($request->shelter);
        $animalItems = $shelter->allAnimalItems;
        $username = auth()->user()->name;

        // Raspon datum ce nam vratiti jedinke
        $dateRangeAnimal = $this->dateRangeAnimal($request, $animalItems);
        
        // Ako se ne odabere raspon, provjeravat ce sve animalIteme u odabranom oporavilištu
        $data = (!empty($dateRangeAnimal)) ? $dateRangeAnimal : $animalItems;

        // Kvartal
        $kvartal = $this->kvartal($request);

        $potrazivani_troskovi = $this->potrazivani_troskovi($data);
        $potrazivani_troskoviSZJ = isset($potrazivani_troskovi['SZJ']['data']) ? count($potrazivani_troskovi['SZJ']['data']) : 0;
        $potrazivani_troskoviZJ = isset($potrazivani_troskovi['ZJ']['data']) ? count($potrazivani_troskovi['ZJ']['data']) : 0;
        $potrazivani_troskoviIJ = isset($potrazivani_troskovi['IJ']['data']) ? count($potrazivani_troskovi['IJ']['data']) : 0;

        // Veterinar oporavilišta
        $vet = $this->vet($data);
        $vetSZJ = isset($vet['SZJ']['data']) ? count($vet['SZJ']['data']) : 0;
        $vetZJ = isset($vet['ZJ']['data']) ? count($vet['ZJ']['data']) : 0;
        $vetIJ = isset($vet['IJ']['data']) ? count($vet['IJ']['data']) : 0;

        // Vanjski veterinar
        $outVet = $this->outVet($data);
        $outVetSZJ = isset($outVet['SZJ']['data']) ? count($outVet['SZJ']['data']) : 0;
        $outVetZJ = isset($outVet['ZJ']['data']) ? count($outVet['ZJ']['data']) : 0;
        $outVetIJ = isset($outVet['IJ']['data']) ? count($outVet['IJ']['data']) : 0;

        $allPrice = [
            isset($potrazivani_troskovi['SZJ']['price']) ? $potrazivani_troskovi['SZJ']['price'] : 0,
            isset($potrazivani_troskovi['ZJ']['price']) ? $potrazivani_troskovi['ZJ']['price'] : 0,
            isset($potrazivani_troskovi['IJ']['price']) ? $potrazivani_troskovi['IJ']['price'] : 0,
            isset($vet['SZJ']['price']) ? $vet['SZJ']['price'] : 0,
            isset($vet['ZJ']['price']) ? $vet['ZJ']['price'] : 0,
            isset($vet['IJ']['price']) ? $vet['IJ']['price'] : 0,
            isset($outVet['SZJ']['price']) ? $outVet['SZJ']['price'] : 0,
            isset($outVet['ZJ']['price']) ? $outVet['ZJ']['price'] : 0,
            isset($outVet['IJ']['price']) ? $outVet['IJ']['price'] : 0,
        ];

        $totalPrice = 0;
        foreach ($allPrice as $price) {
            if(isset($price['price'])){
                //$allPrice += $price["price"];
                dump($price);
            }
        }

        dd($totalPrice);

        $pdf = PDF::loadView('reports.znspdf', compact(
            'animalItems', 'username', 'shelter',
            'vetSZJ', 'vetZJ', 'vetIJ',
            'outVetSZJ', 'outVetZJ', 'outVetIJ',
            'kvartal',
            'potrazivani_troskoviSZJ', 'potrazivani_troskoviZJ', 'potrazivani_troskoviIJ'
        ));

        // Save PDF
        // Storage::put('public/files/pdf'.$id.'.pdf', $pdf->output());
        return $pdf->stream('reports.znspdf');
        // return redirect()->back()->with('izvj', 'Uspješno spremljen izvještaj');
    }

    public function potrazivani_troskovi($animal)
    {
        $data = [];

        foreach ($animal as $item) {
            foreach ($item->animal->animalType as $key) {
                if($key->type_code == 'SZJ' && $item->animal_item_care_end_status == 0){
                    $data['SZJ']['data'][] = $item;
                    $data['SZJ']['price'] = ['price' => $item->shelterAnimalPrice->total_price];
                }
                if($key->type_code == 'ZJ' && $item->animal_item_care_end_status == 0){
                    $data['ZJ']['data'][] = $item;
                    $data['ZJ']['price'] = ['price' => $item->shelterAnimalPrice->total_price];
                }
                if($key->type_code == 'IJ' && $item->animal_item_care_end_status == 0){
                    $data['IJ']['data'][] = $item;
                    $data['IJ']['price'] = ['price' => $item->shelterAnimalPrice->total_price];
                }
            }
        }

        return $data;
    }

    public function kvartal($request)
    {
        $data = [];
        $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date);
        $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date);
        $year = Carbon::now()->format('Y');

        // 1. 1.1.xxxx - 1.3.xxxx
        $start1 = Carbon::parse('01.01.'.$year);
        $end1 = Carbon::parse('01.03.'.$year);
        // 2. 1.4.xxxx - 30.6.xxxx
        $start2 = Carbon::parse('01.04.'.$year);
        $end2 = Carbon::parse('30.06.'.$year);
        // 3. 1.7.xxxx - 30.9.xxxx
        $start3 = Carbon::parse('01.07.'.$year);
        $end3 = Carbon::parse('30.09.'.$year);
        // 4. 1.10.xxxx - 31.12.xxxx
        $start4 = Carbon::parse('01.10.'.$year);
        $end4 = Carbon::parse('31.12.'.$year);

        if($startDate > $start1 && $startDate < $end1 || $endDate > $start1 && $endDate < $end1){
            $data = ['kvartal' => 1, 'date' => ['startDate' => $startDate->format('d.m.Y'), 'endDate' => $endDate->format('d.m.Y')]];
        }
        if($startDate > $start2 && $startDate < $end2 || $endDate > $start2 && $endDate < $end2){
            $data = ['kvartal' => 2, 'date' => ['startDate' => $startDate->format('d.m.Y'), 'endDate' => $endDate->format('d.m.Y')]];
        }
        if($startDate > $start3 && $startDate < $end3 || $endDate > $start3 && $endDate < $end3){
            $data = ['kvartal' => 3, 'date' => ['startDate' => $startDate->format('d.m.Y'), 'endDate' => $endDate->format('d.m.Y')]];
        }
        if($startDate > $start4 && $startDate < $end4 || $endDate > $start4 && $endDate < $end4){
            $data = ['kvartal' => 4, 'date' => ['startDate' => $startDate->format('d.m.Y'), 'endDate' => $endDate->format('d.m.Y')]];
        }

        return $data;
    }

    public function dateRangeAnimal($request, $animalItems)
    {
        $data = [];

        if($request->start_date && $request->end_date){
            $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

            foreach($animalItems as $item){
                $data = 
                $item->whereHas('dateRange', function ($query) use ($request) {
                    $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
                    $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

                    $query->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->orWhere('end_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate);
                })->get();
            }
        }

        return $data;
    }

    public function vet($animalItems)
    {
        $euthanasiaData = [];
        foreach ($animalItems as $item) {
            if(!empty($item->euthanasia)){
                if($item->euthanasia->shelter_staff_id == 1){
                    foreach ($item->animal->animalType as $key) {
                        if($key->type_code == 'SZJ'){
                            $euthanasiaData['SZJ']['data'][] = $item->euthanasia;
                            $euthanasiaData['SZJ']['price'] = ['price' => $item->euthanasia->price];
                        }
                        if($key->type_code == 'ZJ'){
                            $euthanasiaData['ZJ']['data'][] = $item->euthanasia;
                            $euthanasiaData['ZJ']['price'] = ['price' => $item->euthanasia->price];
                        }
                        if($key->type_code == 'IJ'){
                            $euthanasiaData['IJ']['data'][] = $item->euthanasia;
                            $euthanasiaData['IJ']['price'] = ['price' => $item->euthanasia->price];
                        }
                    }
                }
            }
        }

        return $euthanasiaData;
    }

    public function outVet($animalItems)
    {
        $euthanasiaData = [];
        foreach ($animalItems as $item) {
            if(!empty($item->euthanasia)){
                if($item->euthanasia->shelter_staff_id == 2){
                    foreach ($item->animal->animalType as $key) {
                        if($key->type_code == 'SZJ'){
                            $euthanasiaData['SZJ']['data'][] = $item->euthanasia;
                            $euthanasiaData['SZJ']['price'] = ['price' => $item->euthanasia->price];
                        }
                        if($key->type_code == 'ZJ'){
                            $euthanasiaData['ZJ']['data'][] = $item->euthanasia;
                            $euthanasiaData['ZJ']['price'] = ['price' => $item->euthanasia->price];
                        }
                        if($key->type_code == 'IJ'){
                            $euthanasiaData['IJ']['data'][] = $item->euthanasia;
                            $euthanasiaData['IJ']['price'] = ['price' => $item->euthanasia->price];
                        }
                    }
                }
            }
        }

        return $euthanasiaData;
    }

    public function exportToExcel(Request $request)
    {
        $animal = Animal::find($request->animal);

        // Date Range
        if($request->start_date && $request->end_date){
            $animals = $animal->animalItems()
                ->whereHas('dateRange', function ($query) use ($request) {
                    $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
                    $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

                    $query->where('start_date', '>=', $startDate)
                    ->where('start_date', '<=', $endDate)
                    ->orWhere('end_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate);
                })
                ->orDoesntHave("shelter")->whereHas('shelter', function($query) use ($request){
                    $query->where('id', $request->shelter);
                })
                ->orDoesntHave("careEnd")->whereHas('careEnd', function($query) use ($request){
                    $query->where('animal_item_care_end_type_id', $request->care_end_type);
                })
                ->get();
        }

        // Export
        // $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('d.m.Y');
        // $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date)->format('d.m.Y');
        // $name = 'zns-'.$startDate.'-'.$endDate;
        // return (new ZnsExport)->data($animals)->download($name.'.xlsx');

        dd($animals);
    }
}
