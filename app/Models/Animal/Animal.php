<?php

namespace App\Models\Animal;

use App\Models\Shelter\Shelter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory;

    public function animalCategory()
    {
        return $this->belongsTo(AnimalCategory::class);
    }

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function animalAttributes()
    {
        return $this->hasMany(AnimalAttribute::class);
    }

    public function animalCodes()
    {
        return $this->belongsToMany(AnimalCode::class);
    }
}
