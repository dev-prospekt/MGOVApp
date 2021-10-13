<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $shelters = Shelter::with('users')
            ->whereHas('users', function ($q) {
                $q->where('email', auth()->user()->email);
            })
            ->get();

        // Ukupni broj zivotinja
        $countAnimal = Shelter::with('animalItems')
            ->whereHas('animalItems', function ($q) {
                $q->where('shelter_id', auth()->user()->shelter->id);
            })->first();
        
        return view('dashboard', compact('shelters', 'countAnimal'));
    }
}
