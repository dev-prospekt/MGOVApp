<?php

namespace App\Http\Controllers;

use App\Models\FounderData;
use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use Yajra\Datatables\Datatables;
use App\Models\Shelter\ShelterType;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\FounderDataRequest;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FounderDataController extends Controller
{

    public function index(Request $request, Shelter $shelter)
    {
        $founders = FounderData::with('shelter')->where('shelter_id', $shelter->id)->get();

        if ($request->ajax()) {
            return Datatables::of($founders)
                ->addColumn('action', function ($founder) {
                    $deleteUrl = route('shelters.founders.destroy', [$founder->shelter->id, $founder->id]);
                    $editUrl = route('shelters.founders.edit', [$founder->shelter->id, $founder->id]);

                    return '
                    <div class="d-flex align-items-center">
                        <a href="' . $editUrl . '" class="edit btn btn-xs btn-info mr-2">
                            Uredi
                        </a>
                        <a href="javascript:void()" class="trash btn btn-xs btn-danger mr-2" data-href="' . $deleteUrl . '">
                            Brisanje
                        </a>

                       
                    </div>
                    ';
                })->make(true);
        }

        return view('founder.index', [
            'founders' => $founders,
            'shelter' => $shelter,
        ]);
    }

    public function create(Shelter $shelter)
    {
        $type = ShelterType::all();

        return view('founder.create', [
            'type' => $type,
            'shelter' => $shelter,
        ]);
    }

    public function store(FounderDataRequest $request)
    {
        try {
            $founder = new FounderData;
            $founder->shelter_id = $request->shelter;
            $founder->shelter_type_id = $request->shelter_type;
            $founder->name = $request->name;
            $founder->lastname = $request->lastname;
            $founder->address = $request->address;
            $founder->country = $request->country;
            $founder->contact = $request->contact;
            $founder->email = $request->email;
            $founder->service = $request->service;
            $founder->others = $request->others;
            $founder->save();

            if ($request->founder_documents) {
                $founder->addMultipleMediaFromRequest(['founder_documents'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('founder_documents');
                    });
            }

            return redirect()->back()->with('founder', 'Uspješno. Dodali ste novog nalaznika.');
        } catch (\Throwable $th) {
            Log::error('Creating founder : ' . $th->getMessage());
            return view('pages.error.500');
        }
    }

    public function edit(Shelter $shelter, FounderData $founder)
    {
        $mediaFiles = $founder->getMedia('founder_documents');
        $type = ShelterType::all();

        return view('founder.edit', [
            'founder' => $founder,
            'mediaFiles' => $mediaFiles,
            'type' => $type
        ]);
    }

    public function update(Request $request, Shelter $shelter, FounderData $founder)
    {
        $founder->shelter_id = $shelter->id;
        $founder->shelter_type_id = $request->shelter_type;
        $founder->name = $request->name;
        $founder->lastname = $request->lastname;
        $founder->address = $request->address;
        $founder->country = $request->country;
        $founder->contact = $request->contact;
        $founder->email = $request->email;
        $founder->service = $request->service;
        $founder->others = $request->others;
        $founder->save();

        if ($request->founder_documents) {
            $founder->addMultipleMediaFromRequest(['founder_documents'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('founder_documents');
                });
        }

        return redirect()->back()->with('msg_update', 'Uspješno ažurirano.');
    }

    public function destroy(Shelter $shelter, FounderData $founder)
    {
        $founder->delete();

        return response()->json(['msg' => 'success']);
    }

    public function fileDelete($file)
    {
        $media = Media::find($file);
        $media->delete();

        return response()->json(['msg' => 'success']);
    }

    public function modalCreateFounder(Shelter $shelter)
    {
        $type = ShelterType::all();

        $returnHTML = view('founder.modalCreate', ['type' => $type, 'shelter' => $shelter])->render();

        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function createFounder(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'service' => 'required',
                'shelter_type' => 'required',
                'name' => 'required',
                'lastname' => 'required',
                'contact' => 'required',
                'founder_documents' => 'required',
            ],
            [
                'service.required' => 'Služba koja je izvršila zaplijenu je obvezno polje',
                'shelter_type.required' => 'Tip jedinke je obvezno polje',
                'name.required' => 'Ime je obvezno polje',
                'lastname.required' => 'Prezime je obvezno polje',
                'contact.required' => 'Kontakt mobitel/telefon je obvezno polje',
                'founder_documents.required' => 'Dokumentacija je obvezno polje',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $founder = new FounderData;
        $founder->shelter_id = $request->shelter;
        $founder->shelter_type_id = $request->shelter_type;
        $founder->name = $request->name;
        $founder->lastname = $request->lastname;
        $founder->address = $request->address;
        $founder->country = $request->country;
        $founder->contact = $request->contact;
        $founder->email = $request->email;
        $founder->service = $request->service;
        $founder->others = $request->others;
        $founder->save();

        if ($request->founder_documents) {
            $founder->addMultipleMediaFromRequest(['founder_documents'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('founder_documents');
                });
        }

        return response()->json(['success' => 'Uspješno dodano.']);
    }
}
