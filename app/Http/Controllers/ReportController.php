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

        if(empty($request->start_date) || empty($request->end_date)){
            return redirect()->back()->with('msg', 'Raspon datuma je obavezan');
        }

        // Raspon datuma ce nam vratiti jedinke
        $data = $this->dateRangeAnimal($request, $animalItems);

        // Kvartal
        $kvartal = $this->kvartal($request);

        $potrazivani_troskovi = $this->potrazivani_troskovi($data);
        $potrazivani_troskoviSZJ = isset($potrazivani_troskovi['SZJ']['data']) ? $potrazivani_troskovi['SZJ']['price'] : 0;
        $potrazivani_troskoviZJ = isset($potrazivani_troskovi['ZJ']['data']) ? $potrazivani_troskovi['ZJ']['price'] : 0;
        $potrazivani_troskoviIJ = isset($potrazivani_troskovi['IJ']['data']) ? $potrazivani_troskovi['IJ']['price'] : 0;

        // Proširena skrb - ukupna cijena
        $fullCareTotalPrice = $this->price($potrazivani_troskoviSZJ);
        // Zaplijena skrb - ukupna cijena
        $seizedTotalPrice = $this->price($potrazivani_troskoviZJ);

        // Veterinar oporavilišta
        $vet = $this->vet($data, 3);
        $vetSZJ = isset($vet['SZJ']['data']) ? $vet['SZJ']['price'] : 0;
        $vetZJ = isset($vet['ZJ']['data']) ? $vet['ZJ']['price'] : 0;
        $vetIJ = isset($vet['IJ']['data']) ? $vet['IJ']['price'] : 0;

        // Cijene veterinara oporavilišta
        $priceVetSZJ = $this->price($vetSZJ);
        $priceVetZJ = $this->price($vetZJ);
        $priceVetIJ = $this->price($vetIJ);

        // Vanjski veterinar
        $outVet = $this->vet($data, 4);
        $outVetSZJ = isset($outVet['SZJ']['data']) ? $outVet['SZJ']['price'] : 0;
        $outVetZJ = isset($outVet['ZJ']['data']) ? $outVet['ZJ']['price'] : 0;
        $outVetIJ = isset($outVet['IJ']['data']) ? $outVet['IJ']['price'] : 0;

        // Cijene vanjskog veterinara
        $priceVetOutSZJ = $this->price($outVetSZJ);
        $priceVetOutZJ = $this->price($outVetZJ);
        $priceVetOutIJ = $this->price($outVetIJ);

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
        foreach ($allPrice as $key => $value) {
            if(!empty($value)){
                foreach ($value as $price) {
                    $price = collect($price);
                    foreach ($price as $total_price) {
                        $totalPrice += $total_price;
                    }
                }
            }
        }

        $pdf = PDF::loadView('reports.znspdf', compact(
            'animalItems', 'username', 'shelter',
            'priceVetSZJ', 'priceVetZJ', 'priceVetIJ',
            'priceVetOutSZJ', 'priceVetOutZJ', 'priceVetOutIJ',
            'kvartal',
            'fullCareTotalPrice', 'seizedTotalPrice', 'potrazivani_troskoviIJ',
            'totalPrice'
        ));

        // Save PDF
        // Storage::put('public/files/pdf'.$id.'.pdf', $pdf->output());
        return $pdf->stream('reports.znspdf');
        // return redirect()->back()->with('izvj', 'Uspješno spremljen izvještaj');
    }

    public function price($data)
    {
        $price = 0;
        if($data != 0){
            foreach ($data as $key => $value) {
                foreach ($value as $key => $value) {
                    $price += $value;
                }
            }
        }

        return $price;
    }

    public function potrazivani_troskovi($animal)
    {
        $data = [];

        foreach ($animal as $item) {
            foreach ($item->animal->animalType as $key) {
                if($key->type_code == 'SZJ' && $item->animal_item_care_end_status == 0){
                    if(!empty($item->euthanasia)){
                        if(isset($item->shelterAnimalPrice->total_price)){
                            $price = ($item->shelterAnimalPrice->total_price - $item->euthanasia->price);
                        }
                        else {
                            $price = 0;
                        }
                    }
                    else {
                        $price = $item->shelterAnimalPrice->total_price;
                    }
                    $data['SZJ']['data'][] = $item;
                    $data['SZJ']['price'][] = ['price' => $price];
                }
                if($key->type_code == 'ZJ' && $item->animal_item_care_end_status == 0){
                    if(!empty($item->euthanasia)){
                        if(isset($item->shelterAnimalPrice->total_price)){
                            $price = ($item->shelterAnimalPrice->total_price - $item->euthanasia->price);
                        }
                        else {
                            $price = 0;
                        }
                    }
                    else {
                        $price = $item->shelterAnimalPrice->total_price;
                    }
                    $data['ZJ']['data'][] = $item;
                    $data['ZJ']['price'][] = ['price' => $price];
                }
                if($key->type_code == 'IJ' && $item->animal_item_care_end_status == 0){
                    if(!empty($item->euthanasia)){
                        if($item->shelterAnimalPrice->total_price != null){
                            $price = ($item->shelterAnimalPrice->total_price - $item->euthanasia->price);
                        }
                        else {
                            $price = 0;
                        }
                    }
                    else {
                        $price = $item->shelterAnimalPrice->total_price;
                    }
                    $data['IJ']['data'][] = $item;
                    $data['IJ']['price'][] = ['price' => $price];
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

    public function vet($animalItems, $number)
    {
        $euthanasiaData = [];
        foreach ($animalItems as $item) {
            if(!empty($item->euthanasia)){
                if($item->euthanasia->shelterStaff->shelter_staff_type_id == $number){
                    foreach ($item->animal->animalType as $key) {
                        if($key->type_code == 'SZJ'){
                            $euthanasiaData['SZJ']['data'][] = $item->euthanasia;
                            $euthanasiaData['SZJ']['price'][] = ['price' => $item->euthanasia->price];
                        }
                        if($key->type_code == 'ZJ'){
                            $euthanasiaData['ZJ']['data'][] = $item->euthanasia;
                            $euthanasiaData['ZJ']['price'][] = ['price' => $item->euthanasia->price];
                        }
                        if($key->type_code == 'IJ'){
                            $euthanasiaData['IJ']['data'][] = $item->euthanasia;
                            $euthanasiaData['IJ']['price'][] = ['price' => $item->euthanasia->price];
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
