<?php

namespace App\Http\Controllers\Animal;

use PDF;
use Carbon\Carbon;
use App\Models\DateRange;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\DateFullCare;
use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalData;
use App\Models\Animal\AnimalFile;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalGroup;
use App\Models\ShelterAnimalPrice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Animal\AnimalItemFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AnimalItemPostRequest;
use App\Http\Requests\AnimalItemFilePostRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AnimalItemController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
    {
        $animalItem = AnimalItem::find($animalItem->id);
        $animalGroup = $animalItem->animalGroup;
        $paginateLogs = $animalItem->latestAnimalItemLogs()->paginate(2);
        $price = (isset($animalItem->shelterAnimalPrice)) ? $animalItem->shelterAnimalPrice : null;
        $date = $animalItem->dateRange;
        $solitaryGroup = $animalItem->dateSolitaryGroups;

        // Početak - Solitarno, Grupa
        $startSolitaryGroup = $animalItem->dateSolitaryGroups()->where('end_date', '=', null)->first();
        // Grupiranje - Solitarno, Grupa
        $allSolitaryGroup = collect($animalItem->dateSolitaryGroups);
        $allSolitaryGroup = $allSolitaryGroup->where('end_date', '!=', null)->groupBy('solitary_or_group')->all();

        // Hibernacija : Da ili Ne
        $hibern = $animalItem->dateRange->where('animal_item_id', '=', $animalItem->id)
            ->where('hibern_start', '!=', null)
            ->first();

        // Full Care
        $fullCare = $animalItem->dateFullCare;
        $lastFullCare = $animalItem->dateFullCare()->where('end_date', '=', null)->latest()->take(1)->first();

        $dateFullCare_total = $animalItem->dateFullCare;
        $countDays = 0;
        foreach ($dateFullCare_total as $key) {
            $countDays += $key->days;
        }
        $maxDate = 10;
        $totalDays = ($maxDate - $countDays);

        // Omoguci prosirenu skrb (prioritetne vrste)
        $arrayAnimalForFullCare = [];
        foreach ($animalItem->animal->animalCodes as $item) {
            if($item->name == 'PZ'){
                $arrayAnimalForFullCare = Arr::prepend($arrayAnimalForFullCare, $animalItem->animal_id);
            }
        }

        return view('animal.animal_item.show', [
            'animalItem' => $animalItem,
            'paginateLogs' => $paginateLogs,
            'hibern' => $hibern,
            'fullCare' => $fullCare,
            'lastFullCare' => $lastFullCare,
            'totalDays' => $totalDays,
            'price' => $price,
            'date' => $date,
            'solitaryGroup' => $solitaryGroup,
            'startSolitaryGroup' => $startSolitaryGroup,
            'allSolitaryGroup' => $allSolitaryGroup,
            'arrayAnimalForFullCare' => $arrayAnimalForFullCare
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
    {
        $mediaItems = $animalItem->getMedia('status_receiving_file');

        $size = $animalItem->animal->animalSize;
        $dateRange = $animalItem->dateRange;
        $dateFullCare_total = $animalItem->dateFullCare;

        $countDays = 0;
        foreach ($dateFullCare_total as $key) {
            $countDays += $key->days;
        }
        $maxDate = 10;
        $totalDays = ($maxDate - $countDays);

        return view('animal.animal_item.edit', [
            'animalItem' => $animalItem,
            'mediaItems' => $mediaItems,
            'size' => $size,
            'dateRange' => $dateRange,
            'totalDays' => $totalDays,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnimalItemPostRequest $request, $id)
    {
        $animalItem = AnimalItem::findOrFail($id);
        $animalDobOld = $animalItem->animal_age;
        $animalItem->animal_size_attributes_id = $request->animal_size_attributes_id;
        $animalItem->animal_age = $request->animal_dob;
        $animalItem->animal_gender = $request->animal_gender;
        $animalItem->save();

        // Update cijene ako više nije JUV ili obrnuto
        // Pokrenut ce samo ako promijenimo status dobi
        // if($animalDobOld != $animalItem->animal_age){
        //     $updateDob = (new AnimalItemPriceController($animalItem))->updateDob();
        // }

        return redirect()->back()->with('msg_update', 'Uspješno ažurirano.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shelter $shelter, AnimalGroup $animalGroup, AnimalItem $animalItem)
    {
        $animalItem->delete();

        return response()->json(['msg' => 'success']);
    }

    public function file(AnimalItemFilePostRequest $request)
    {
        $animalItemFile = AnimalItem::find($request->animal_item_id);

        // Update
        if ($request->filenames) {
            foreach ($request->filenames as $key) {
                $animalItemFile->addMedia($key)->toMediaCollection('media');
            }
        }

        return redirect('/animal_item/' . $request->animal_item_id . '/edit')->with('msg', 'Uspješno dodan dokument');
    }

    public function deleteFile($file)
    {
        $media = Media::find($file);
        $media->delete();

        return response()->json(['msg' => 'success']);
    }

    public function activeFullCare(Request $request, AnimalItem $animalItem)
    {
        $status = ($request->id == 1) ? true : false;
        $animalItem->full_care_status = $status;
        $animalItem->update();

        return response()->json(['msg' => 'success']);
    }

    public function cloneAnimalItem($animal_item_id)
    {
        $item = AnimalItem::findOrFail($animal_item_id);
        $newItem = $item->duplicate();
        $newItem->save();

        $newItem->update(['animal_code' => $newItem->shelter_code . '-j-' . $newItem->id]);

        // Media AnimalItemLogs
        $animalItemLog = $item->animalItemLogs;
        foreach ($animalItemLog as $itemLog) {
            $newAnimalItemLog = $itemLog->replicate();
            $newAnimalItemLog->animal_item_id = $newItem->id;
            $newAnimalItemLog->save();

            $this->copyMedia($itemLog, $newAnimalItemLog);
        }
        // Media AnimalItemLogs

        // Media Euthanasia
        if (!empty($newItem->euthanasia)) {
            $euthanasia = $item->euthanasia;
            $newEuthanasia = $newItem->euthanasia;
            $this->copyMedia($euthanasia, $newEuthanasia);
        }
        // Media Euthanasia

        // Copy Media
        if (!empty($item->animalDocumentation)) {
            $this->copyMedia($item->animalDocumentation, $newItem->animalDocumentation);
        }

        return redirect()->back();
    }

    public function changeShelter(Request $request, AnimalItem $animalItem)
    {
        $animal_items = AnimalItem::with('dateRange', 'dateFullCare', 'shelterAnimalPrice', 'animalGroup')->find($animalItem->id);
        $newShelter = Shelter::find($request->selectedShelter);

        // Zadnji ID u grupi
        $incrementId = AnimalGroup::orderBy('id', 'DESC')->first();
        $increment = $incrementId->id + 1;
        $increment = str_pad($increment, 5, 0, STR_PAD_LEFT);

        // AnimalType
        $animalType = Animal::find($animal_items->animal_id);
        $animalTypeCode = $animalType->animalType->first()->type_code;

        // New group
        $newAnimalGroup = new AnimalGroup;
        $newAnimalGroup->animal_id = $animal_items->animal_id;
        $newAnimalGroup->shelter_code = Carbon::now()->format('y') . '' . $newShelter->shelter_code . '/' . $animalTypeCode . '-' . $increment;
        $newAnimalGroup->quantity = 1;
        $newAnimalGroup->save();

        // Pivot table
        $newAnimalGroup->shelters()->attach($newAnimalGroup->id, [
            'shelter_id' => $request->selectedShelter,
            'active_group' => true,
        ]);

        // Update status animalItem
        $animal_items->in_shelter = false;
        $animal_items->save();

        // Copy Item
        $newAnimalItem = $animal_items->replicate();
        $newAnimalItem->animal_group_id = $newAnimalGroup->id;
        $newAnimalItem->shelter_id = $newShelter->id;
        $newAnimalItem->in_shelter = true;
        $newAnimalItem->animal_item_care_end_status = true;
        $newAnimalItem->shelter_code = $newAnimalGroup->shelter_code;
        $newAnimalItem->save();
        $newAnimalItem->update(['animal_code' => $newAnimalGroup->shelter_code . '-j-' . $newAnimalItem->id]);

        // Duplicate solitary group date
        if($animalItem->animal->animalType->first()->type_code != 'IJ'){
            $animalItemsDateSolitaryGroup = $animal_items->dateSolitaryGroups;
            if ($animalItemsDateSolitaryGroup) {
                $newAnimalItem->dateSolitaryGroups()->create([
                    'start_date' => Carbon::now(),
                    'end_date' => null,
                    'solitary_or_group' => $animal_items->dateSolitaryGroups()->latest()->take(1)->first()->solitary_or_group,
                ]);
            }
        }

        // Copy mark_type
        $animalItemAnimalMark = $animal_items->animalMarks;
        if ($animalItemAnimalMark) {
            foreach ($animalItemAnimalMark as $value) {
                $newAnimalMark = $value->replicate();
                $newAnimalMark->animal_item_id = $newAnimalItem->id;
                $newAnimalMark->save();
            }
        }

        // Copy ItemLog
        $allAnimalItemLog = $animal_items->animalItemLogs;
        if ($allAnimalItemLog) {
            foreach ($allAnimalItemLog as $value) {
                $newAnimalItemLog = $value->replicate();
                $newAnimalItemLog->animal_item_id = $newAnimalItem->id;
                $newAnimalItemLog->save();

                // Copy media Item Logs
                $this->copyMedia($value, $newAnimalItemLog);
            }
        }

        // Copy Media
        if ($animal_items->animalDocumentation) {
            $animalItemDoc = $animal_items->animalDocumentation;
            $newAnimalItemDoc = $animalItemDoc->replicate();
            $newAnimalItemDoc->animal_item_id = $newAnimalItem->id;
            $newAnimalItemDoc->save();

            $this->copyMedia($animalItemDoc, $newAnimalItemDoc);
        }

        // // Date full care
        // if (!empty($animal_items->dateFullCare)) {
        //     $dateFullCare = $animal_items->dateFullCare;
        //     if (!empty($dateFullCare)) {
        //         foreach ($dateFullCare as $item) {
        //             $newDateRange = $item->replicate();
        //             $newDateRange->animal_item_id = $newAnimalItem->id;
        //             $newDateRange->save();
        //         }
        //     }
        // }

        // Date Range
        $dateRange = $animal_items->dateRange;
        $newDateRange = $dateRange->replicate();
        $newDateRange->animal_item_id = $newAnimalItem->id;
        $newDateRange->start_date = Carbon::now();
        $newDateRange->end_date = null;
        $newDateRange->hibern_start = null;
        $newDateRange->hibern_end = null;
        $newDateRange->save();

        // // Shelter Animal Price
        // if (!empty($animal_items->shelterAnimalPrice)) {
        //     $animalPrice = $animal_items->shelterAnimalPrice;
        //     $newAnimalPrice = $animalPrice->replicate();
        //     $newAnimalPrice->animal_item_id = $newAnimalItem->id;
        //     $newAnimalPrice->save();
        // }

        return response()->json([
            'msg' => 'success',
            'back' => $request->currentShelter,
            'newShelter' => $newShelter
        ]);
    }

    // Copy Media
    public function copyMedia($model, $newModel)
    {
        // log-docs
        if ($model->getMedia('log-docs')) {
            $documents = $model->getMedia('log-docs');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'log-docs');
            }
        }

        // documents
        if ($model->getMedia('documents')) {
            $documents = $model->getMedia('documents');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'documents');
            }
        }
        // media
        if ($model->getMedia('media')) {
            $documents = $model->getMedia('media');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'media');
            }
        }
        // status_receiving_file
        if ($model->getMedia('state_receive_file')) {
            $documents = $model->getMedia('state_receive_file');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'state_receive_file');
            }
        }
        // status_found_file
        if ($model->getMedia('state_found_file')) {
            $documents = $model->getMedia('state_found_file');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'state_found_file');
            }
        }
        // reason_file
        if ($model->getMedia('state_reason_file')) {
            $documents = $model->getMedia('state_reason_file');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'state_reason_file');
            }
        }
        // animal_mark_photos
        if ($model->getMedia('animal_mark_photos')) {
            $documents = $model->getMedia('animal_mark_photos');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'animal_mark_photos');
            }
        }
        // euthanasia_invoice
        if ($model->getMedia('euthanasia_invoice')) {
            $documents = $model->getMedia('euthanasia_invoice');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'euthanasia_invoice');
            }
        }
        // euthanasia_file
        if ($model->getMedia('euthanasia_file')) {
            $documents = $model->getMedia('euthanasia_file');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'euthanasia_file');
            }
        }
        // seized_doc_type
        if ($model->getMedia('seized_doc_type')) {
            $documents = $model->getMedia('seized_doc_type');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'seized_doc_type');
            }
        }
    }
}
