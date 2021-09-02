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

    // public function animals()
    // {
    //     return $this->hasManyThrough(
    //         Animal::class,
    //         AnimalCategory::class,
    //         'animal_system_category_id',
    //         'animal_category_id'
    //     );
    // }
}
