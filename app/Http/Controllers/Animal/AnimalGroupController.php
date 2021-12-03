<?php

namespace App\Http\Controllers\Animal;

use Carbon\Carbon;
use App\Models\DateRange;
use Illuminate\Http\Request;
use App\Models\Shelter\Shelter;
use Yajra\Datatables\Datatables;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalGroup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AnimalGroupController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Shelter $shelter, AnimalGroup $animalGroup)
    {
        $animal_group = AnimalGroup::with('animalItems', 'shelters')->find($animalGroup->id);
        $animal_items = $animal_group->animalItems;
        
        // Vraca oporaviliste samo koje ima isti type
        $animalType = $animal_group->animal->animalType->first()->type_code;
        $shelters = Shelter::where('id', '!=', $shelter->id)
            ->whereHas('shelterTypes', function ($query) use ($animalType) {
                $query->whereIn('code', [$animalType]);
            })
            ->get();

        if ($request->ajax()) {
            return DataTables::of($animal_items)
                ->addIndexColumn()
                ->addColumn('name', function ($animal_items) {
                    return $animal_items->animal->name;
                })
                ->addColumn('latin_name', function ($animal_items) {
                    return $animal_items->animal->latin_name;
                })
                ->addColumn('action', function ($animal_items) {
                    $url = route('shelters.animal_groups.animal_items.show', [$animal_items->shelter_id, $animal_items->animal_group_id, $animal_items->id]);
                    $cloneUrl = route('animal_item.clone', [$animal_items->id]);

                    return '
                    <div class="d-flex align-items-center">
                        <a href="' . $url . '" class="btn btn-xs btn-info mr-2">
                            Info
                        </a>

                        <a href="' . $cloneUrl . '" class="btn btn-xs btn-primary mr-2">
                            Dupliciraj
                        </a>

                        <a href="javascript:void(0)" id="changeShelterItem" data-id="' . $animal_items->id . '" class="btn btn-xs btn-warning mr-2">
                            Premjesti
                        </a>
                    </div>
                    ';
                })
                ->make();
        }

        return view('animal.animal_group.show', [
            'animal_group' => $animal_group,
            'animal_items' => $animal_items,
            'shelters' => $shelters
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $animalGroup = AnimalGroup::find($id);
        $animalGroup->delete();

        return response()->json(['msg'=>'success']);
    }

    public function groupChangeShelter(Request $request, AnimalGroup $animalGroup)
    {
        $animal_group = AnimalGroup::find($animalGroup->id);
        $newShelter = Shelter::find($request->selectedShelter);

        // Promjena stanja na trenutnoj grupi
        $updatePivot = $animal_group->shelters()->updateExistingPivot($request->currentShelter, array('active_group' => false));

        // Zadnji ID u grupi
        $incrementId = AnimalGroup::orderBy('id', 'DESC')->first();
        $increment = $incrementId->id + 1;

        // Duplicate Grupe sa novom šifrom oporavilišta
        $newAnimalGroup = $animal_group->replicate();
        $newAnimalGroup->shelter_code = Carbon::now()->format('y') . '' . $newShelter->shelter_code . '/' . $increment;
        $newAnimalGroup->save();

        // Novi red u pivot tablici koji povezuje dupliciranu grupu i novo oporavilište
        $newAnimalGroup->shelters()->attach($newAnimalGroup->id, [
            'shelter_id' => $request->selectedShelter,
            'active_group' => true,
        ]);

        // Animal Items - Dupliciranje i promjena Id Sheltera
        $animalItems = AnimalItem::with('dateRange')->where('animal_group_id', $animal_group->id)->get();
        foreach ($animalItems as $item) {
            $newAnimalItems = $item->replicate();
            $newAnimalItems->animal_group_id = $newAnimalGroup->id;
            $newAnimalItems->shelter_id = $newShelter->id;
            $newAnimalItems->save();

            // Date Range dulicate for new items
            $dateRange = $item->dateRange;
            $newDateRange = $dateRange->replicate();
            $newDateRange->animal_item_id = $newAnimalItems->id;
            $newDateRange->save();

            // Date Solitary or Group
            if(!empty($item->dateSolitaryGroups)){
                $dateSolitaryOrGroupRange = $item->dateSolitaryGroups;
                if(!empty($dateSolitaryOrGroupRange)){
                    foreach ($dateSolitaryOrGroupRange as $value) {
                        $newDateSolitaryOrGroupRange = $value->replicate();
                        $newDateSolitaryOrGroupRange->animal_item_id = $newAnimalItems->id;
                        $newDateSolitaryOrGroupRange->save();
                    }
                }
            }

            // Date full care
            if(!empty($item->dateFullCare))
            {
                $dateFullCare = $item->dateFullCare;
                if(!empty($dateFullCare)){
                    foreach ($dateFullCare as $item) {
                        $newDateRange = $item->replicate();
                        $newDateRange->animal_item_id = $newAnimalItems->id;
                        $newDateRange->save();
                    }
                }
            }

            // Euthanasia
            if(!empty($item->euthanasia)){
                $euthanasia = $item->euthanasia;
                $newEuthanasia = $euthanasia->animal_item_id = $newAnimalItems->id;
                $newEuthanasia->save();
            }

            // Shelter Animal Price
            if(!empty($item->shelterAnimalPrice))
            {
                $animalPrice = $item->shelterAnimalPrice;
                $newAnimalPrice = $animalPrice->replicate();
                $newAnimalPrice->animal_item_id = $newAnimalItems->id;
                $newAnimalPrice->save();
            }

            // Kopija dokumenata
            $this->copyMedia($item, $newAnimalItems);
        }

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
        if($model->getMedia('log-docs')){
            $documents = $model->getMedia('log-docs');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'log-docs');
            }
        }

        // documents
        if($model->getMedia('documents')){
            $documents = $model->getMedia('documents');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'documents');
            }
        }
        // media
        if($model->getMedia('media')){
            $documents = $model->getMedia('media');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'media');
            }
        }
        // status_receiving_file
        if($model->getMedia('status_receiving_file')){
            $documents = $model->getMedia('status_receiving_file');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'status_receiving_file');
            }
        }
        // status_found_file
        if($model->getMedia('status_found_file')){
            $documents = $model->getMedia('status_found_file');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'status_found_file');
            }
        }
        // reason_file
        if($model->getMedia('reason_file')){
            $documents = $model->getMedia('reason_file');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'reason_file');
            }
        }
        // animal_mark_photos
        if($model->getMedia('animal_mark_photos')){
            $documents = $model->getMedia('animal_mark_photos');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'animal_mark_photos');
            }
        }
        // euthanasia_invoice
        if($model->getMedia('euthanasia_invoice')){
            $documents = $model->getMedia('euthanasia_invoice');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'euthanasia_invoice');
            }
        }
        // euthanasia_file
        if($model->getMedia('euthanasia_file')){
            $documents = $model->getMedia('euthanasia_file');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'euthanasia_file');
            }
        }
        // seized_doc_type
        if($model->getMedia('seized_doc_type')){
            $documents = $model->getMedia('seized_doc_type');
            foreach ($documents as $item) {
                $copiedMediaItem = $item->copy($newModel, 'seized_doc_type');
            }
        }
    }
}
