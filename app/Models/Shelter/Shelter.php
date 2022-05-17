<?php

namespace App\Models\Shelter;

use App\Models\User;
use App\Models\FounderData;
use App\Models\Animal\Animal;
use App\Models\Animal\AnimalItem;
use App\Models\Animal\AnimalGroup;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal\AnimalSystemCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shelter extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'register_date' => 'date',
    ];

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

    public function animalGroups()
    {
        return $this->belongsToMany(AnimalGroup::class)->where('active_group', 1)->with('animal');
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

    public function founder()
    {
        return $this->hasMany(FounderData::class);
    }

    public function allAnimalItems()
    {
        return $this->hasMany(AnimalItem::class)
        ->where('in_shelter', 1)
        ->where('shelter_id', auth()->user()->shelter_id)
        ->where('animal_item_care_end_status', 1);
    }

    public function animalForYear()
    {
        return $this->hasMany(AnimalItem::class)
        ->whereYear('created_at', \Carbon\Carbon::now()->format('Y'))
        ->where('shelter_id', auth()->user()->shelter_id);
    }

    public function excelAnimalItems()
    {
        return $this->hasMany(AnimalItem::class);
    }

    public function animalItems()
    {
        return $this->hasMany(AnimalItem::class)->where('in_shelter', 1);
    }

    public function animalItemSends()
    {
        return $this->hasMany(AnimalItem::class)->where('in_shelter', 0);
    }
}
