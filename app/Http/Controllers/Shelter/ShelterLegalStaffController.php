<?php

namespace App\Http\Controllers\Shelter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shelter\ShelterStaff;
use App\Models\Shelter\ShelterStaffType;
use Illuminate\Support\Facades\Validator;

class ShelterLegalStaffController extends Controller
{

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'oib' => 'required',
            'address' => 'required',
            'address_place' => 'required',
            'phone' => 'required',
            'phone_cell' => 'required',
            'email' => 'required',
            'staff_legal_file' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $shelterStaffType = ShelterStaffType::where('name', 'pravno odgovorna osoba')->first();

        $shelterStaff = ShelterStaff::create([
            'shelter_staff_type_id' => $shelterStaffType->id,
            'shelter_id' => $request->shelter_id,
            'name' => $request->name,
            'oib' => $request->oib,
            'address' => $request->address,
            'address_place' => $request->address_place,
            'phone' => $request->phone,
            'phone_cell' => $request->phone_cell,
            'email' => $request->email,
        ]);

        if ($request->hasFile('staff_legal_file')) {
            $shelterStaff->addMediaFromRequest('staff_legal_file')->toMediaCollection('legal-docs');
        }

        return response()->json(['success' => 'Red je uspješno kreiran.']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'oib' => 'required',
            'address' => 'required',
            'address_place' => 'required',
            'phone' => 'required',
            'phone_cell' => 'required',
            'email' => 'required',
            'staff_legal_file' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        ShelterStaff::find($id)->update([
            'shelter_id' => $request->shelter_id,
            'name' => $request->name,
            'oib' => $request->oib,
            'address' => $request->address,
            'address_place' => $request->address_place,
            'phone' => $request->phone,
            'phone_cell' => $request->phone_cell,
            'email' => $request->email,
        ]);

        $shelterStaff = ShelterStaff::where('shelter_id', $request->shelter_id)->get()
            ->filter(function ($item) {
                return $item->shelter_staff_type_id == 1;
            })->last();

        if ($request->hasFile('staff_legal_file')) {
            $shelterStaff->clearMediaCollection('legal-docs');
            $shelterStaff->addMediaFromRequest('staff_legal_file')->toMediaCollection('legal-docs');
        }

        return response()->json(['success' => 'Pravna osoba uspješno spremljena.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shelterLegalStaff = new ShelterStaff;
        $shelterLegalStaff::find($id)->delete();

        return response()->json(['success' => 'Osoba je uspješno izbrisana']);
    }
}
