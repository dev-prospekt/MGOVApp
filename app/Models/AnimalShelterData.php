<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalShelterData extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function animalUnit()
    {
        return $this->belongsTo(AnimalUnit::class);
    }
}
