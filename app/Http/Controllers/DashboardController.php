<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard', [
            'user_name' => 'Pero',
            'user_lastname' => 'Perić',
        ]);
    }

}
