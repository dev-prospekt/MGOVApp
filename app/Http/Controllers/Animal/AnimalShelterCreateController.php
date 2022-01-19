<?php

namespace App\Http\Controllers\Animal;

use Carbon\Carbon;
use App\Mail\WelcomeMail;
use App\Models\DateRange;
use App\Models\FounderData;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalMark;
use App\Models\Animal\AnimalGroup;
use App\Models\Shelter\ShelterType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Animal\AnimalMarkType;
use App\Http\Requests\AnimalProtectedCreateRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Animal\AnimalItemDocumentationStateType;

class AnimalShelterCreateController extends Controller
{
    // View
    public function createView(Shelter $shelter)
    {
        $shelterType = $shelter->shelterTypes;

        return view('animal.animal.create', [
            'shelterType' => $shelterType,
            'shelter' => $shelter
        ]);
    }

    // Get Founder
    public function getFounder(Request $request)
    {
        if (!$request->type_id) {
            $html = '<option value="">-----</option>';
        } 
        else {
            $html = '';
            $founderSelect = FounderData::where('shelter_type_id', $request->type_id)
            ->where('shelter_id', $request->shelter)
            ->get();

            $html = '<option value="">-----</option>';
            foreach ($founderSelect as $item) {
                $html .= '
                <option value="' . $item->id . '">' . $item->name . '</option>
                ';
            }
        }

        return response()->json(['html' => $html]);
    }

    // Get Form
    public function getForm(Request $request)
    {
        if (isset($request)) {
            if ($request->type_id) {

                if ($request->type_id == 3) {
                    return $this->protectedCreate($request->type_id, $request->shelter);
                }
                if ($request->type_id == 2) {
                    return $this->invasiveCreate($request->type_id, $request->shelter);
                }
                if ($request->type_id == 1) {
                    return $this->seizedCreate($request->type_id, $request->shelter);
                }
            }
        }
    }

    // Slanje emaila administratoru oporavilišta
    public function sendMail($data)
    {
        $adminEmail = 'kristijan.marijic@prospekt.hr';
        // $adminEmail = $data->shelter->email;

        Mail::to($adminEmail)->send(new WelcomeMail($data));
    }

    // Strogo zaštićene
    public function protectedCreate($type_id, $shelter)
    {
        return $this->viewForm($type_id, 'protected', $shelter);
    }

    public function protectedStore(Request $request)
    {
        // Increment ID
        $incrementId = AnimalGroup::orderBy('id', 'DESC')->first();
        if (empty($incrementId->id)) {
            $increment = 1;
        } else {
            $increment = $incrementId->id + 1;
        }
        $increment = str_pad($increment, 5, 0, STR_PAD_LEFT);

        // AnimalType
        $animalType = Animal::find($request->animal_id);
        $animalTypeCode = $animalType->animalType->first()->type_code;

        // Shelter Code: 21AW/SZ-0001

        $animal_group = new AnimalGroup;
        $animal_group->animal_id = $request->animal_id;
        $animal_group->shelter_code = Carbon::now()->format('y') . '' . $request->shelter_code . '/' . $animalTypeCode . '-' . $increment;
        $animal_group->quantity = 0;
        $animal_group->save();

        // Pivot table
        $animal_group->shelters()->attach($animal_group->id, [
            'shelter_id' => $request->shelter_id,
            'active_group' => true,
        ]);

        // Create AnimalItem
        $animalItem = new AnimalItem;
        $animalItem->animal_group_id = $animal_group->id;
        $animalItem->animal_id = $request->animal_id;
        $animalItem->shelter_id = $request->shelter_id;
        $animalItem->founder_id = $request->founder_id;
        $animalItem->brought_animal_id = $request->brought_animal; // Tko je donio životinju
        $animalItem->founder_note = $request->founder_note;
        $animalItem->animal_size_attributes_id = $request->animal_size_attributes_id;
        $animalItem->in_shelter = true;
        $animalItem->animal_found_note = $request->animal_found_note;
        $animalItem->animal_date_found =  $request->date_found;
        $animalItem->animal_gender = $request->animal_gender;
        $animalItem->animal_age = $request->animal_age;
        $animalItem->location = $request->location;
        $animalItem->location_animal_takeover = $request->location_animal_takeover;
        $animalItem->solitary_or_group = $request->solitary_or_group;
        $animalItem->shelter_code = $animal_group->shelter_code;

        $animalItem->save();

        $animalItem->update(['animal_code' => $animal_group->shelter_code . '-j-' . $animalItem->id]);

        // AnimalDocumentation
        $animalDocumentation = $animalItem->animalDocumentation()->create([
            'animal_item_id' => $animalItem->id,
            'state_recive' => $request->status_receiving,
            'state_recive_desc' => $request->status_receiving_desc,
            'state_found' => $request->status_found,
            'state_found_desc' => $request->status_found_desc,
            'state_reason' => $request->status_reason,
            'state_reason_desc' => $request->reason_desc,
        ]);

        $this->createDocuments($request, $animalDocumentation);

        // Date Range
        if (!empty($request->start_date)) {
            $date_range = new DateRange;
            $date_range->animal_item_id = $animalItem->id;
            $date_range->start_date = Carbon::createFromFormat('m/d/Y', $request->start_date);
            if ($request->hib_est == 'da') {
                $date_range->hibern_start = Carbon::createFromFormat('m/d/Y', $request->hibern_start);
            }
            $date_range->save();
        }

        // Solitary/Group
        $animalItem->dateSolitaryGroups()->create([
            'animal_item_id' => $animalItem->id,
            'start_date' => Carbon::createFromFormat('m/d/Y', $request->start_date),
            'solitary_or_group' => $animalItem->solitary_or_group,
        ]);

        // Send email
        //$sendEmail = $this->sendMail($animalItem);

        return redirect()->route('shelter.show', $request->shelter_id)->with('msg', 'Uspješno dodano.');
    }

    // Invazivne
    public function invasiveCreate($type_id, $shelter)
    {
        return $this->viewForm($type_id, 'invasive', $shelter);
    }

    public function invasiveStore(Request $request)
    {
        //dd($request);

        // Increment ID
        $incrementId = AnimalGroup::orderBy('id', 'DESC')->first();
        if (empty($incrementId->id)) {
            $increment = 1;
        } else {
            $increment = $incrementId->id + 1;
        }
        $increment = str_pad($increment, 5, 0, STR_PAD_LEFT);

        // AnimalType
        $animalType = Animal::find($request->animal_id);
        $animalTypeCode = $animalType->animalType->first()->type_code;

        // Shelter Code: 21AW/SZ-0001

        $animal_group = new AnimalGroup;
        $animal_group->animal_id = $request->animal_id;
        $animal_group->shelter_code = Carbon::now()->format('y') . '' . $request->shelter_code . '/' . $animalTypeCode . '-' . $increment;
        $animal_group->quantity = 0;
        $animal_group->save();

        // Pivot table
        $animal_group->shelters()->attach($animal_group->id, [
            'shelter_id' => $request->shelter_id,
            'active_group' => true,
        ]);

        // Create AnimalItem
        $animalItem = new AnimalItem;
        $animalItem->shelter_id = $request->shelter_id;
        $animalItem->animal_group_id = $animal_group->id;
        $animalItem->shelter_code = $animal_group->shelter_code;
        $animalItem->animal_id = $request->animal_id;
        $animalItem->animal_date_found = isset($request->date_found) ? $request->date_found : null;
        $animalItem->animal_gender = $request->animal_gender;
        $animalItem->animal_age = $request->animal_age;
        $animalItem->location = $request->location;
        $animalItem->location_retrieval_animal = $request->location_retrieval_animal;
        $animalItem->founder_id = $request->founder_id;
        $animalItem->brought_animal_id = $request->brought_animal; // Tko je donio životinju
        $animalItem->founder_note = $request->founder_note;
        // $animalItem->solitary_or_group = $request->solitary_or_group;

        if ($request->euthanasia_select == 'da') {
            $animalItem->euthanasia_ammount = $request->euthanasia_ammount;
        }

        $animalItem->in_shelter = true;
        $animalItem->save();

        $animalItem->update(['animal_code' => $animal_group->shelter_code . '-j-' . $animalItem->id]);

        // AnimalDocumentation
        $animalDocumentation = $animalItem->animalDocumentation()->create([
            'animal_item_id' => $animalItem->id,
        ]);

        $this->createDocuments($request, $animalDocumentation);

        // Date Range
        if (!empty($request->start_date)) {
            $date_range = new DateRange;
            $date_range->animal_item_id = $animalItem->id;
            $date_range->start_date = Carbon::createFromFormat('m/d/Y', $request->start_date);
            $date_range->save();
        }

        // // Solitary/Group
        // if (!empty($animalItem->solitary_or_group)) {
        //     $animalItem->dateSolitaryGroups()->create([
        //         'animal_item_id' => $animalItem->id,
        //         'start_date' => Carbon::createFromFormat('m/d/Y', $request->start_date),
        //         'solitary_or_group' => $animalItem->solitary_or_group,
        //     ]);
        // }

        return redirect()->route('shelter.show', $request->shelter_id)->with('msg', 'Uspješno dodano.');
    }

    // Zaplijena
    public function seizedCreate($type_id, $shelter)
    {
        return $this->viewForm($type_id, 'seized', $shelter);
    }

    public function seizedStore(Request $request)
    {
        //dd($request);

        // Increment ID
        $incrementId = AnimalGroup::orderBy('id', 'DESC')->first();
        if (empty($incrementId->id)) {
            $increment = 1;
        } else {
            $increment = $incrementId->id + 1;
        }
        $increment = str_pad($increment, 5, 0, STR_PAD_LEFT);

        // AnimalType
        $animalType = Animal::find($request->animal_id);
        $animalTypeCode = $animalType->animalType->first()->type_code;

        // Shelter Code: 21AW/SZ-0001

        $animal_group = new AnimalGroup;
        $animal_group->animal_id = $request->animal_id;
        $animal_group->shelter_code = Carbon::now()->format('y') . '' . $request->shelter_code . '/' . $animalTypeCode . '-' . $increment;
        $animal_group->quantity = 0;
        $animal_group->save();

        // Pivot table
        $animal_group->shelters()->attach($animal_group->id, [
            'shelter_id' => $request->shelter_id,
            'active_group' => true,
        ]);

        // Create AnimalItem
        $animalItem = new AnimalItem;
        $animalItem->shelter_id = $request->shelter_id;
        $animalItem->shelter_code = $animal_group->shelter_code;
        $animalItem->animal_id = $request->animal_id;
        $animalItem->animal_group_id = $animal_group->id;
        $animalItem->animal_gender = $request->animal_gender;
        $animalItem->animal_size_attributes_id = $request->animal_size_attributes_id;
        $animalItem->animal_age = $request->animal_age;
        $animalItem->solitary_or_group = $request->solitary_or_group;

        $animalItem->animal_date_found = isset($request->date_found) ? $request->date_found : null;

        $animalItem->place_seized_select = $request->place_seized_select;
        $animalItem->place_seized = $request->place_seized;
        $animalItem->date_seized_animal = Carbon::createFromFormat('m/d/Y', $request->date_seized_animal);
        $animalItem->location_retrieval_animal = $request->location_retrieval_animal;
        $animalItem->animal_found_note = $request->animal_found_note;
        $animalItem->founder_id = $request->founder_id;
        $animalItem->brought_animal_id = $request->brought_animal; // Tko je donio životinju
        $animalItem->founder_note = $request->founder_note;
        $animalItem->in_shelter = true;
        $animalItem->save();

        $animalItem->update(['animal_code' => $animal_group->shelter_code . '-j-' . $animalItem->id]);

        // AnimalDocumentation
        $animalDocumentation = $animalItem->animalDocumentation()->create([
            'animal_item_id' => $animalItem->id,
            'state_recive' => $request->status_receiving,
            'state_recive_desc' => $request->status_receiving_desc,
            'state_found' => $request->status_found,
            'state_found_desc' => $request->status_found_desc,
            'state_reason' => $request->status_reason,
            'state_reason_desc' => $request->reason_desc,
            'seized_doc' => $request->seized_doc,
        ]);

        $this->createDocuments($request, $animalDocumentation);

        // Date Range
        if (!empty($request->start_date)) {
            $date_range = new DateRange;
            $date_range->animal_item_id = $animalItem->id;
            $date_range->start_date = Carbon::createFromFormat('m/d/Y', $request->start_date);
            if ($request->hib_est == 'da') {
                $date_range->hibern_start = Carbon::createFromFormat('m/d/Y', $request->hibern_start);
            }
            $date_range->save();
        }

        // Solitary/Group
        if (!empty($animalItem->solitary_or_group)) {
            $animalItem->dateSolitaryGroups()->create([
                'animal_item_id' => $animalItem->id,
                'start_date' => Carbon::createFromFormat('m/d/Y', $request->start_date),
                'solitary_or_group' => $animalItem->solitary_or_group,
            ]);
        }

        return redirect()->route('shelter.show', $request->shelter_id)->with('msg', 'Uspješno dodano.');
    }

    // View
    public function viewForm($type_id, $template, $shelter)
    {
        $shelter = Shelter::find($shelter);
        $sysCats = $shelter->animalSystemCategory;
        $founder = FounderData::all();
        $markTypes = AnimalMarkType::all();
        $shelterType = ShelterType::find($type_id);
        $stateType = AnimalItemDocumentationStateType::all();

        $pluckSystemCat = $sysCats->pluck('id');
        $shelterTypeCode = [$shelterType->code];

        $animal = Animal::whereHas('animalType', function ($q) use ($shelterTypeCode) {
                $q->whereIn('type_code', $shelterTypeCode);
            })
            ->whereHas('animalCategory.animalSystemCategory', function ($q) use ($pluckSystemCat) {
                $q->whereIn('id', $pluckSystemCat);
            })
            ->orderBy('name')
            ->get();

        $returnHTML = view("animal.animal.$template", [
            'animal' => $animal,
            'founders' => $founder,
            'markTypes' => $markTypes,
            'shelter' => $shelter,
            'shelterType' => $shelterType,
            'stateType' => $stateType
        ])->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function createDocuments($request, $animalItem)
    {
        if ($request->euthanasia_select == 'da') {
            if (!empty($request->euthanasia_invoice)) {
                $animalItem->addMultipleMediaFromRequest(['euthanasia_invoice'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('euthanasia_file');
                    });
            }
        }

        if ($request->reason_file) {
            $animalItem->addMultipleMediaFromRequest(['reason_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('state_reason_file');
                });
        }

        if ($request->brought_animal_file) {
            $animalItem->addMultipleMediaFromRequest(['brought_animal_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('brought_animal_file');
                });
        }

        if ($request->animal_mark_photos) {
            $animalItem->addMultipleMediaFromRequest(['animal_mark_photos'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('animal_mark_photos');
                });
        }

        if ($request->status_found_file) {
            $animalItem->addMultipleMediaFromRequest(['status_found_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('state_found_file');
                });
        }

        if ($request->status_receiving_file) {
            $animalItem->addMultipleMediaFromRequest(['status_receiving_file'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('state_receive_file');
                });
        }

        if ($request->seized_doc_type) {
            $animalItem->addMultipleMediaFromRequest(['seized_doc_type'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('seized_doc_type');
                });
        }
    }
}
