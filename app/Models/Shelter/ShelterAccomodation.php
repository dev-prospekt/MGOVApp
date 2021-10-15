<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelterAccomodation extends Model
{
    use HasFactory;

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function accommodationTypes()
    {
        return $this->hasMany(ShelterAccomodationType::class);
    }
}
