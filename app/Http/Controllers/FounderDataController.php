<?php

namespace App\Http\Controllers;

use App\Models\FounderData;
use Illuminate\Http\Request;

class FounderDataController extends Controller
{
    public function store(Request $request)
    {   
        $founder = new FounderData;
        $founder->name = $request->name;
        $founder->lastname = $request->lastname;
        $founder->address = $request->address;
        $founder->country = $request->country;
        $founder->contact = $request->contact;
        $founder->email = $request->email;
        $founder->service = $request->service;
        $founder->others = $request->others;
        $founder->save();

        if($request->founder_documents){
            $founder->addMultipleMediaFromRequest(['founder_documents'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('founder_documents');
            });
        }
    
        return redirect('/animal/create')->with('founder', 'Uspješno. Dodali ste novog nalaznika.');
    }
}
