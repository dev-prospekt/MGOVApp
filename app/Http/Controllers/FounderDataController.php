<?php

namespace App\Http\Controllers;

use App\Models\FounderData;
use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use Yajra\Datatables\Datatables;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FounderDataController extends Controller
{

    public function index()
    {
        $founders = FounderData::all();

        return view('founder.index', compact('founders'));
    }

    public function create()
    {
        return view('founder.create');
    }

    public function store(Request $request)
    {   
        $founder = new FounderData;
        $founder->shelter_id = auth()->user()->shelter->id;
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
    
        return redirect()->back()->with('founder', 'Uspješno. Dodali ste novog nalaznika.');
    }

    public function edit(Shelter $shelter, FounderData $founder)
    {
        $mediaFiles = $founder->getMedia('founder_documents');

        return view('founder.edit', [
            'founder' => $founder, 
            'mediaFiles' => $mediaFiles
        ]);
    }

    public function update(Request $request, Shelter $shelter, FounderData $founder)
    {
        $founder->name = $request->name;
        $founder->email = $request->email;
        $founder->shelter_id = auth()->user()->shelter->id;
        $founder->save();

        if($request->founder_documents){
            $founder->addMultipleMediaFromRequest(['founder_documents'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('founder_documents');
            });
        }

        return redirect()->back()->with('msg_update', 'Uspješno ažurirano.');
    }

    public function indexDataTables()
    {
        $founders = FounderData::all();

        return Datatables::of($founders)
            ->addColumn('action', function ($founder) {
            return '
            <div class="d-flex align-items-center">
                <a href="javascript:void()" class="trash btn btn-xs btn-danger mr-2" data-href="'. $founder->id .'">
                    <i class="mdi mdi-tooltip-trash"></i> 
                    Delete
                </a>

                <a href="founder/'.$founder->id.'/edit" class="edit btn btn-xs btn-info mr-2">
                    <i class="mdi mdi-tooltip-edit"></i> 
                    Edit
                </a>
            </div>
            ';
            })->make(true);
    }

    public function destroy(Shelter $shelter, FounderData $founder)
    {
        $founder->delete();

        return response()->json(['msg'=>'success']);
        //return redirect()->route("founder.index")->with('msg', 'Uspješno obrisano.');
    }

    public function fileDelete($file)
    {
        $media = Media::find($file);
        $media->delete();

        return response()->json(['msg' => 'success']);
    }
}
