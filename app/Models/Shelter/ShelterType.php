<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelterType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class);
    }
}
