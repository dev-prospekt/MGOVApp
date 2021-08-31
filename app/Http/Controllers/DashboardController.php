<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $shelters = Shelter::with('shelterTypes', 'users')->get();


        return view('dashboard', compact('shelters'));
    }
}
