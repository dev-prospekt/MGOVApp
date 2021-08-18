<?php

namespace App\Http\Controllers;

use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $shelters = Shelter::all();

        return view('dashboard', [
            'user' => $user,
            'shelters' => $shelters
        ]);
    }
}
