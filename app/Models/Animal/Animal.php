<?php

namespace App\Models\Animal;

use App\Models\Shelter\Shelter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory;

    public function animalCategory()
    {
        return $this->belongsTo(AnimalCategory::class)->with('animalSystemCategory');
    }

    public function animalAttributes()
    {
        return $this->hasMany(AnimalAttribute::class);
    }

    public function animalCodes()
    {
        return $this->belongsToMany(AnimalCode::class);
    }

    public function animalItems()
    {
        return $this->hasMany(AnimalItem::class);
    }

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class)->withPivot('id');
    }
}
