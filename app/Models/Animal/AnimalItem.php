<?php

namespace App\Models\Animal;

use App\Models\DateRange;
use App\Models\DateFullCare;
use App\Models\Shelter\Shelter;

use Spatie\MediaLibrary\HasMedia;
use App\Models\Animal\AnimalGroup;
use App\Models\ShelterAnimalPrice;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function animal()
    {
        return $this->belongsTo(Animal::class)->with('animalSize', 'animalCategory');
    }

    public function animalGroup()
    {
        return $this->belongsTo(AnimalGroup::class);
    }

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function animalSizeAttributes()
    {
        return $this->belongsTo(AnimalSizeAttribute::class);
    }

    public function dateRange()
    {
        return $this->hasOne(DateRange::class);
    }

    public function dateFullCare()
    {
        return $this->hasMany(DateFullCare::class);
    }

    public function animalMark()
    {
        return $this->belongsTo(AnimalMark::class)->with('animalMarkTypes');
    }

    public function shelterAnimalPrice()
    {
        return $this->hasOne(ShelterAnimalPrice::class);
    }

    public function animalItemLogs()
    {
        return $this->hasMany(AnimalItemLog::class);
    }
}
