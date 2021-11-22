<?php

namespace App\Models\Shelter;

use App\Models\User;
use App\Models\Animal\Animal;
use App\Models\Animal\AnimalItem;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal\AnimalSystemCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shelter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];



    public function shelterTypes()
    {
        return $this->belongsToMany(ShelterType::class);
    }

    public function animalSystemCategory()
    {
        return $this->belongsToMany(AnimalSystemCategory::class);
    }

    public function users()
    {
        return $this->hasMany(User::class)->with('roles');
    }

    public function animals()
    {
        return $this->belongsToMany(Animal::class)
            ->with('animalCodes', 'animalItems')
            ->where('quantity', '>', 0)
            ->withPivot('quantity', 'shelter_code', 'id')
            ->withTimestamps();
    }

    public function animalItems()
    {
        return $this->hasMany(AnimalItem::class);
    }

    public function shelterStaff()
    {
        return $this->hasMany(ShelterStaff::class);
    }

    public function accomodations()
    {
        return $this->hasMany(ShelterAccomodation::class);
    }

    public function nutritionItems()
    {
        return $this->hasMany(ShelterNutrition::class);
    }

    public function getRegisterDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('m/d/Y');
    }
}
