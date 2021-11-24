<?php

namespace App\Models\Animal;

use App\Models\Animal\Animal;
use App\Models\Shelter\Shelter;
use App\Models\Animal\AnimalItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalGroup extends Model
{
    use HasFactory;

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class)->where('active_group', 1);
    }

    public function animals()
    {
        return $this->belongsTo(Animal::class);
    }

    public function animalItems()
    {
        return $this->hasMany(AnimalItem::class);
    }
}
