<?php

namespace App\Models\Animal;

use App\Models\Shelter\ShelterUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalItem extends Model
{
    use HasFactory;

    public function animalCategory()
    {
        return $this->belongsTo(AnimalCategory::class);
    }

    public function shelterUnits()
    {
        return $this->belongsToMany(ShelterUnit::class);
    }
}
