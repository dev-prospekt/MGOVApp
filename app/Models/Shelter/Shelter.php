<?php

namespace App\Models\Shelter;

use App\Models\User;
use App\Models\Animal\Animal;
use App\Models\Animal\AnimalItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shelter extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function shelterTypes()
    {
        return $this->belongsToMany(ShelterType::class);
    }

    public function users()
    {
        return $this->hasMany(User::class)->with('roles');
    }

    public function animals()
    {
        return $this->belongsToMany(Animal::class)
                    ->where('quantity', '>', 0)
                    ->with('animalItems', 'animalCategory')
                    ->withPivot('quantity', 'shelterCode', 'id');
    }

    public function animalItems()
    {
        return $this->hasMany(AnimalItem::class);
    }
}
