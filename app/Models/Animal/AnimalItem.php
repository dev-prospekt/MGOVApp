<?php

namespace App\Models\Animal;

use App\Models\DateRange;
use App\Models\DateFullCare;
use App\Models\Shelter\Shelter;

use Spatie\MediaLibrary\HasMedia;
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

    public function animalFile()
    {
        return $this->belongsTo(AnimalFile::class);
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

    public function shelterAnimalPrice()
    {
        return $this->hasOne(ShelterAnimalPrice::class);
    }
}
