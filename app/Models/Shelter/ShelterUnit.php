<?php

namespace App\Models\Shelter;

use App\Models\User;
use App\Models\Animal\AnimalItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShelterUnit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function shelterTypes()
    {
        return $this->belongsToMany(ShelterType::class);
    }

    public function users()
    {
        return $this->hasMany(\App\Models\User::class)->with('roles');
    }

    public function animalItems()
    {
        return $this->belongsToMany(AnimalItem::class);
    }
}
