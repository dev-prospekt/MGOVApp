<?php

namespace App\Models\Animal;

use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Animal\AnimalItem;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalGroup extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class)->withPivot('active_group')->where('active_group', 1);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function animalItems()
    {
        return $this->hasMany(AnimalItem::class)->where('in_shelter', 1);
    }

    public function animalItemActive()
    {
        return $this->hasMany(AnimalItem::class)
        ->where('in_shelter', 1)
        ->where('animal_item_care_end_status', 1);
    }
    
    public function animalItemInactive()
    {
        return $this->hasMany(AnimalItem::class)
        ->where('in_shelter', 1)
        ->where('animal_item_care_end_status', 0);
    }

    public function animalGroupLogs()
    {
        return $this->hasMany(AnimalGroupLog::class);
    }
}
