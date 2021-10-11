<?php

namespace App\Http\Controllers\Shelter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shelter\ShelterStaff;
use App\Models\Shelter\ShelterStaffType;
use Illuminate\Support\Facades\Validator;

class ShelterCareStaffController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'staff_care_name' => 'required',
            'staff_care_oib' => 'required',
            'staff_care_address' => 'required',
            'staff_care_address_place' => 'required',
            'staff_care_phone' => 'required',
            'staff_care_phone_cell' => 'required',
            'staff_care_email' => 'required',
            'staff_care_education' => 'required',
            'staff_contract_file' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $shelterStaffType = ShelterStaffType::where('name', 'osoba odgovorna za skrb životinja')->first();

        $shelterStaff = ShelterStaff::create([
            'shelter_staff_type_id' => $shelterStaffType->id,
            'shelter_id' => $request->shelter_id,
            'name' => $request->staff_care_name,
            'oib' => $request->staff_care_oib,
            'address' => $request->staff_care_address,
            'address_place' => $request->staff_care_address_place,
            'phone' => $request->staff_care_phone,
            'phone_cell' => $request->staff_care_phone_cell,
            'email' => $request->staff_care_email,
            'education' => $request->staff_care_education,
        ]);

        if ($request->hasFile('staff_contract_file')) {
            $shelterStaff->addMediaFromRequest('staff_contract_file')->toMediaCollection('contract-docs');
        }

        if ($request->hasFile('staff_certificate_file')) {
            $shelterStaff->addMediaFromRequest('staff_certificate_file')->toMediaCollection('certificate-docs');
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
            'staff_care_name' => 'required',
            'staff_care_oib' => 'required',
            'staff_care_address' => 'required',
            'staff_care_address_place' => 'required',
            'staff_care_phone' => 'required',
            'staff_care_phone_cell' => 'required',
            'staff_care_email' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        ShelterStaff::find($id)->update([
            'shelter_id' => $request->shelter_id,
            'name' => $request->staff_care_name,
            'oib' => $request->staff_care_oib,
            'address' => $request->staff_care_address,
            'address_place' => $request->staff_care_address_place,
            'phone' => $request->staff_care_phone,
            'phone_cell' => $request->staff_care_phone_cell,
            'email' => $request->staff_care_email,
            'education' => $request->staff_care_education,
        ]);

        $shelterStaff = ShelterStaff::careStaff($request->shelter_id)->last();

        if ($request->hasFile('staff_contract_file')) {
            $shelterStaff->clearMediaCollection('contract-docs');
            $shelterStaff->addMediaFromRequest('staff_contract_file')->toMediaCollection('contract-docs');
        }

        if ($request->hasFile('staff_certificate_file')) {
            $shelterStaff->clearMediaCollection('certificate-docs');
            $shelterStaff->addMediaFromRequest('staff_certificate_file')->toMediaCollection('certificate-docs');
        }

        return response()->json(['success' => 'Pravna osoba uspješno spremljena.', 'request' => $request->all()]);
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
