<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Exports\ZnsExport;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Animal\AnimalItemCareEndType;

class ReportController extends Controller
{
    public function viewReports()
    {
        $animals = Animal::all();
        $shelters = Shelter::all();
        $endCareType = AnimalItemCareEndType::all();

        return view('reports.index', [
            'animals' => $animals,
            'shelters' => $shelters,
            'endCareType' => $endCareType,
        ]);
    }

    public function generateZNS(Request $request)
    {   
        $animalItems = AnimalItem::find(2);

        $pdf = PDF::loadView('reports.znspdf', compact('animalItems'));

        // Save PDF
        // Storage::put('public/files/pdf'.$id.'.pdf', $pdf->output());
        return $pdf->stream('reports.znspdf');
        // return redirect()->back()->with('izvj', 'Uspješno spremljen izvještaj');
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
                ->orWhereHas('careEnd', function($query) use ($request){
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
