<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\Animal\AnimalItem;

class ReportController extends Controller
{
    public function generateZNS()
    {
        $animalItems = AnimalItem::find(1);

        $pdf = PDF::loadView('znspdf', compact('animalItems'));

        // Save PDF
        // Storage::put('public/files/pdf'.$id.'.pdf', $pdf->output());
        return $pdf->stream('znspdf');
        // return redirect()->back()->with('izvj', 'Uspješno spremljen izvještaj');
    }
}
