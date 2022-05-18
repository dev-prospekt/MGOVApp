<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $shelters = Shelter::with('users', 'allAnimalItems')
            ->whereHas('users', function ($query) {
                $query->where('email', auth()->user()->email);
            })
            ->get();

        $allAnimalForAdmin = AnimalItem::whereYear('created_at', Carbon::now()->format('Y'))->get();

        return view('dashboard', compact('shelters', 'allAnimalForAdmin'));
    }
}
