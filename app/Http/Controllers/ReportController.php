<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function viewReports()
    {
        $animals = Animal::all();
        $shelters = Shelter::all();

        return view('reports.exporttoexcel', [
            'animals' => $animals,
            'shelters' => $shelters,
        ]);
    }

    public function generateZNS()
    {
        $animalItems = AnimalItem::find(1);

        $pdf = PDF::loadView('reports.znspdf', compact('animalItems'));

        // Save PDF
        // Storage::put('public/files/pdf'.$id.'.pdf', $pdf->output());
        return $pdf->stream('reports.znspdf');
        // return redirect()->back()->with('izvj', 'Uspješno spremljen izvještaj');
    }

    public function exportToExcel(Request $request)
    {
        $animal = Animal::find($request->animal);
        $shelter = Shelter::find($request->shelter);

        // Date Range
        if($request->start_date && $request->end_date){
            $animal = $animal->animalItems()->where('shelter_id', $request->shelter)->whereHas('dateRange', function ($query) use ($request) {
                $startDate = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

                $query->where('start_date', '>=', $startDate)
                ->where('start_date', '<=', $endDate)
                ->orWhere('end_date', '>=', $startDate)
                ->where('end_date', '<=', $endDate);
            })
            ->get();
        }
        
        $collection = collect([
            'data' => [
                'animal' => $animal,
                'shelter' => $shelter
            ]
        ]);

        dd($collection);
    }
}
