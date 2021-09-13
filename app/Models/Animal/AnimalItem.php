<?php

namespace App\Models\Animal;

use App\Models\Shelter\Shelter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalItem extends Model
{
    use HasFactory;

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function animalItemsFile()
    {
        return $this->hasMany(AnimalItemFile::class);
    }
}
