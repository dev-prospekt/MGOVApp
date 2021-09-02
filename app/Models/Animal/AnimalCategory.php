<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalCategory extends Model
{
    use HasFactory;

    public function animalSystemCategory()
    {
        return $this->belongsTo(AnimalSystemCategory::class);
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}