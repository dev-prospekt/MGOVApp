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

        // Veterinar oporavilišta
        $vet = $this->vet($data);
        $vetSZJ = isset($vet['SZJ']) ? count($vet['SZJ']) : 0;
        $vetZJ = isset($vet['ZJ']) ? count($vet['ZJ']) : 0;
        $vetIJ = isset($vet['IJ']) ? count($vet['IJ']) : 0;

        // Vanjski veterinar
        $outVet = $this->outVet($data);
        $outVetSZJ = isset($outVet['SZJ']) ? count($outVet['SZJ']) : 0;
        $outVetZJ = isset($outVet['ZJ']) ? count($outVet['ZJ']) : 0;
        $outVetIJ = isset($outVet['IJ']) ? count($outVet['IJ']) : 0;

        $pdf = PDF::loadView('reports.znspdf', compact(
            'animalItems', 'username', 'shelter',
            'vetSZJ', 'vetZJ', 'vetIJ',
            'outVetSZJ', 'outVetZJ', 'outVetIJ',
        ));

        // Save PDF
        // Storage::put('public/files/pdf'.$id.'.pdf', $pdf->output());
        return $pdf->stream('reports.znspdf');
        // return redirect()->back()->with('izvj', 'Uspješno spremljen izvještaj');
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
                            $euthanasiaData['SZJ'][] = $item->euthanasia;
                        }
                        if($key->type_code == 'ZJ'){
                            $euthanasiaData['ZJ'][] = $item->euthanasia;
                        }
                        if($key->type_code == 'IJ'){
                            $euthanasiaData['IJ'][] = $item->euthanasia;
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
                            $euthanasiaData['SZJ'][] = $item->euthanasia;
                        }
                        if($key->type_code == 'ZJ'){
                            $euthanasiaData['ZJ'][] = $item->euthanasia;
                        }
                        if($key->type_code == 'IJ'){
                            $euthanasiaData['IJ'][] = $item->euthanasia;
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
