<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Reports;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Exports\ReportsExport;
use App\Models\Shelter\Shelter;
use Yajra\DataTables\DataTables;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalOrder;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Animal\AnimalCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\Animal\AnimalSystemCategory;
use App\Models\Animal\AnimalItemCareEndType;

class ReportController extends Controller
{
    public function viewReports(Request $request)
    {
        $animals = Animal::all();
        $animalCategory = AnimalCategory::all();
        $animalOrder = AnimalOrder::all();
        $animalSystemCat = AnimalSystemCategory::all();
        $endCareType = AnimalItemCareEndType::all();

        if(auth()->user()->hasRole('Administrator')){
            $shelters = Shelter::all();
        } else {
            $shelters = Shelter::where('id', auth()->user()->shelter_id)->get();
        }

        $myReport = Reports::where('shelter_id', auth()->user()->shelter->id)->get();
        $reportAdmin = Reports::all();
        $reports = (auth()->user()->hasRole('Administrator')) ? $reportAdmin : $myReport;

        if ($request->ajax()) {
            return DataTables::of($reports)
            ->addColumn('name', function ($reports) {
                return $reports->name;
            })
            ->addColumn('date', function ($reports) {
                return $reports->created_at->format('d.m.Y');
            })
            ->addColumn('document', function ($reports) {
                $file = $reports->getMedia('report_file')->first();
                $url = $file->getUrl();
                $filename = $file->file_name;
                
                return '
                <div>
                    <a class="" href="'.$url.'" target="_blank">
                        '.$filename.'
                    </a>
                </div>
                ';
            })
            ->addColumn('shelter', function ($reports) {
                return $reports->user->shelter->name;
            })
            ->addColumn('author', function ($reports) {
                return $reports->user->name;
            })
            ->addColumn('status', function ($reports) {
                switch ($reports->status) {
                    case true:
                        $btn_class = 'success';
                        $btn_text = 'Odobreno';
                        break;
                    case false:
                        $btn_class = 'danger';
                        $btn_text = 'Nije odobreno';
                        break;
                    default:
                        $btn_class = 'light';
                }
                return  '<span class="badge badge-' . ($btn_class) . '">' . $btn_text . '</span>';
            })
            ->addColumn('action', function ($reports) {
                $deleteURL = route('report-delete', $reports->id);
                $status = $reports->status == true ? 0 : 1;
                $statusUrl = route('report-status', $reports->id);
                $statustxt = $reports->status == 1 ? 'Odustani' : 'Odobri';

                if(auth()->user()->hasRole('Administrator')){
                    return '
                    <div class="d-flex align-items-center">
                        <a href="javascript:void(0)" data-url="' . $deleteURL . '" id="deleteReports" class="btn btn-xs btn-danger mr-2">
                            Obriši
                        </a>
                        <a href="javascript:void(0)" data-url="'.$statusUrl.'" data-id="' . $status . '" id="reportStatus" class="btn btn-xs btn-info mr-2">
                            '.$statustxt.'
                        </a>
                    </div>
                    ';
                }

                return '';
            })
            ->rawColumns(['action', 'document', 'status'])
            ->make();
        }

        return view('reports.index', [
            'animals' => $animals,
            'shelters' => $shelters,
            'endCareType' => $endCareType,
            'animalCategory' => $animalCategory,
            'animalOrder' => $animalOrder,
            'animalSystemCat' => $animalSystemCat,
        ]);
    }

    // MODAL
    public function createModal() 
    {
        $returnHTML = view('reports._create')->render();
        return response()->json( array('success' => true, 'html' => $returnHTML) );
    }

    public function changeStatus(Request $request, Reports $report)
    {
        $report->status = $request->status;
        $report->save();

        return response()->json(['status' => 'ok']);
    }

    public function saveReport(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'author' => 'required',
                'report_file' => 'required',
            ],
            [
                'name.required' => 'Naziv je obvezno polje',
                'report_file.required' => 'Dokument je obvezno polje',
            ]
        );

        if ($validator->fails()) {
            return response()->json([ 'status' => 'error', 'message' => $validator->errors()->all()]);
        }

        $report = new Reports;
        $report->name = $request->name;
        $report->author = $request->author;
        $report->shelter_id = $request->shelter;
        $report->date = Carbon::now();
        $report->addMultipleMediaFromRequest(['report_file'])
        ->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('report_file');
        });
        $report->save();

        return response()->json(['status' => 'ok', 'message' => 'Uspješno dodano.']);
    }

    public function deleteReport(Reports $report)
    {
        $report->delete();

        return response()->json(['status' => 'ok']);
    }

    ///////////////////////////////////////////////////
    ///////////////////////////////////////////////////
    ///////////////////////////////////////////////////
    ///////////////////////////////////////////////////

    public function generateZNS(Request $request)
    {
        $shelter = Shelter::find($request->shelter);
        $animalItems = $shelter->allAnimalItems->where('animal_item_care_end_status', 0);
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

        // Strogo zasticena - ukupna cijena
        $SZJTotalPrice = $this->price($potrazivani_troskoviSZJ);
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
            'SZJTotalPrice', 'seizedTotalPrice', 'potrazivani_troskoviIJ',
            'totalPrice'
        ));

        $nameZNSReport = '';
        // Save PDF
        // Storage::put('public/files/pdf'.$id.'.pdf', $pdf->output());
        return $pdf->stream('reports.pdf');
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
        $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date);
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
            $data = [
                'kvartal' => 1, 
                'date' => ['startDate' => $startDate->format('d.m.Y'), 'endDate' => $endDate->format('d.m.Y')],
                'kvartal_start_date' => $start1,
                'kvartal_end_date' => $end1,
            ];
        }
        if($startDate > $start2 && $startDate < $end2 || $endDate > $start2 && $endDate < $end2){
            $data = [
                'kvartal' => 2, 
                'date' => ['startDate' => $startDate->format('d.m.Y'), 'endDate' => $endDate->format('d.m.Y')],
                'kvartal_start_date' => $start2,
                'kvartal_end_date' => $end2,
            ];
        }
        if($startDate > $start3 && $startDate < $end3 || $endDate > $start3 && $endDate < $end3){
            $data = [
                'kvartal' => 3, 
                'date' => ['startDate' => $startDate->format('d.m.Y'), 'endDate' => $endDate->format('d.m.Y')],
                'kvartal_start_date' => $start3,
                'kvartal_end_date' => $end3,
            ];
        }
        if($startDate > $start4 && $startDate < $end4 || $endDate > $start4 && $endDate < $end4){
            $data = [
                'kvartal' => 4, 
                'date' => ['startDate' => $startDate->format('d.m.Y'), 'endDate' => $endDate->format('d.m.Y')],
                'kvartal_start_date' => $start4,
                'kvartal_end_date' => $end4,
            ];
        }

        return $data;
    }

    public function dateRangeAnimal($request, $animalItems)
    {
        $data = [];

        if($request->start_date && $request->end_date){
            foreach($animalItems as $item){
                $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
                $itemStartDate = Carbon::parse($item->dateRange->start_date);
                $itemEndDate = Carbon::parse($item->dateRange->end_date);
                
                if( $itemStartDate > $startDate && $itemStartDate <= $endDate )
                {
                    $data[] = $item;
                }
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

    //////////////////////////////////////
    //////////////////////////////////////
    //////////////////////////////////////
    //////////////////////////////////////
    // EXPORT TO EXCEL

    public function exportToExcel(Request $request)
    {
        $shelter = ($request->shelter != 'all') ? Shelter::find($request->shelter) : 'all';
        $animalCat = AnimalCategory::find($request->animal_category);
        $animalOrder = AnimalOrder::find($request->animal_order);
        $animalSysteCat = AnimalSystemCategory::find($request->animal_system);
        $animalSysteCat = AnimalSystemCategory::find($request->animal_system);
        $species = Animal::find($request->species);

        if(empty($request->start_date) || empty($request->end_date)){
            return redirect()->back()->with('msg', 'Raspon datuma je obavezan');
        }

        // Get Animal
        $data = $this->exportGetAnimal($request, $species, $animalCat, $animalOrder, $animalSysteCat, $shelter);
        //dd($data);
        // Get Animal Date Range
        $dateRange = $this->exportDateRangeAnimal($request, $data, $shelter);
        // Care End Type
        $careEndType = $this->exportCareEndType($request, $dateRange);
        
        $finishData = $careEndType;

        // Export
        $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('d.m.Y');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('d.m.Y');
        $name = 'excel-'.$startDate.'-'.$endDate;

        $kvartal = $this->kvartal($request);

        return (new ReportsExport($finishData, $kvartal))->download($name.'.xlsx');
    }

    public function exportGetAnimal($request, $species = null, $animalCat = null, $animalOrder = null, $animalSysteCat = null, $shelter)
    {
        $data = [];

        if(empty($species) && empty($animalCat) && empty($animalOrder) && empty($animalSysteCat))
        {
            if($shelter == 'all'){
                $animalItems = AnimalItem::all();
                foreach ($animalItems as $animalItem) {
                    $data = $animalItems;
                }
            }
            else {
                $animalItems = $shelter->allAnimalItems;
                foreach ($animalItems as $item) {
                    if($item->shelter_id == $shelter->id){
                        $data[] = $item;
                    }
                }
            }
        }
        if($species){
            foreach ($species->animalItems as $item) {
                if($shelter == 'all'){
                    $data[] = $item;
                }
                else {
                    if($item->shelter_id == $shelter->id){
                        $data[] = $item;
                    }
                }
            }
        }
        if($animalCat){
            foreach ($animalCat->animals as $animals) {
                foreach ($animals->animalItems as $animalItems) {
                    if($shelter == 'all'){
                        $data[] = $animalItems;
                    }
                    else {
                        if($animalItems->shelter_id == $shelter->id){
                            $data[] = $animalItems;
                        }
                    }   
                }
            }
        }
        if($animalOrder){
            foreach ($animalOrder->animalCategory as $animalcat) {
                foreach ($animalcat->animals as $animal) {
                    foreach ($animal->animalItems as $item) {
                        if($shelter == 'all'){
                            $data[] = $item;
                        }
                        else {
                            if($item->shelter_id == $shelter->id){
                                $data[] = $item;
                            }
                        }
                    }
                }
            }
        }
        if($animalSysteCat){
            foreach ($animalSysteCat->animalCategory as $animalcat) {
                foreach ($animalcat->animals as $animal) {
                    foreach ($animal->animalItems as $item) {
                        if($shelter == 'all'){
                            $data[] = $item;
                        }
                        else {
                            if($item->shelter_id == $shelter->id){
                                $data[] = $item;
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function exportDateRangeAnimal($request, $animalItem, $shelter)
    {
        $data = [];

        if($animalItem){
            foreach ($animalItem as $item) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
                $itemStartDate = Carbon::parse($item->dateRange->start_date);
                $itemEndDate = Carbon::parse($item->dateRange->end_date);

                if($shelter == 'all'){
                    if( $itemStartDate > $startDate && $itemStartDate <= $endDate )
                    {
                        $data[] = $item;
                    }
                }
                else {
                    if( $item->shelter_id == $shelter->id && 
                        $itemStartDate > $startDate && $itemStartDate <= $endDate )
                    {
                        $data[] = $item;
                    }
                }
            }
        }

        return $data;
    }

    public function exportCareEndType($request, $animal)
    {
        $data = [];

        if($animal){
            foreach ($animal as $item) {
                if($request->care_end_type){
                    if(!empty($item->careEnd)){
                        if($request->care_end_type == $item->careEnd->animal_item_care_end_type_id){
                            $data[] = $item;
                        }
                    }
                }
                else {
                    $data[] = $item;
                }
            }
        }

        return $data;
    }
}
