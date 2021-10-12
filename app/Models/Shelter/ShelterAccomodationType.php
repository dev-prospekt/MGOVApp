<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelterAccomodationType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function shelterAccomodation()
    {
        return $this->belongsTo(ShelterAccomodation::class);
    }
}
