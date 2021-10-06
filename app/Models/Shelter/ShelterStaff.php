<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelterStaff extends Model
{
    use HasFactory;

    public function shelter()
    {
        return $this->belongsTo(ShelterStaff::class);
    }

    public function staffType()
    {
        return $this->hasMany(ShelterStaffType::class);
    }
}
