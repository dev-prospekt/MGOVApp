<?php

namespace App\Models\Animal;

use App\Models\Shelter\ShelterUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalSystemCategory extends Model
{
    use HasFactory;

    public function shelterUnit()
    {
        return $this->belongsTo(ShelterUnit::class);
    }

    public function animalCategory()
    {
        return $this->hasMany(AnimalCategory::class);
    }
}
