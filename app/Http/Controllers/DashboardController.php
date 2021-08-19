<?php

namespace App\Http\Controllers;

use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->id != 2){
            $shelters = Shelter::where('user_id', '=', Auth::user()->id)->get();
        }
        else {
            $shelters = Shelter::all();
        }

        return view('dashboard', [
            'shelters' => $shelters
        ]);
    }
}
