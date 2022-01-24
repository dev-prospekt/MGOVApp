<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FounderService;

class FounderServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $returnHTML = view("founderService.create")->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $founderService = new FounderService;
        $founderService->name = $request->name;
        $founderService->save();

        return redirect()->back()->with('founder-service-msg', 'Uspješno spremljeno');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FounderService $founderService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FounderService $founderService)
    {
        $returnHTML = view("founderService.edit", [ 'founderService' => $founderService ])->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FounderService $founderService)
    {
        $founderService->name = $request->name;
        $founderService->save();

        return redirect()->back()->with('founder-service-msg', 'Uspješno ažurirano');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FounderService $founderService)
    {
        $founderService->delete();
        
        return response()->json(array('status' => 'ok', 'message' => 'Uspješno obrisano'));
    }
}
