<?php

namespace App\Models\Animal;

use App\Models\Shelter\ShelterStaff;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Euthanasia extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function animalItem()
    {
        return $this->belongsTo(AnimalItem::class);
    }

    public function shelterStaff()
    {
        return $this->belongsTo(ShelterStaff::class);
    }
}
