<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function animalData()
    {
        return $this->hasManyThrough(
            AnimalShelterData::class,
            AnimalUnit::class,
            'shelter_id',
            'animal_unit_id'
        );
    }

    public function animalUnits()
    {
        return $this->hasMany(AnimalUnit::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
