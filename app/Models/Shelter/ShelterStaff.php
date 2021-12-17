<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ShelterStaff extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];


    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }


    public function scopeLegalStaff($query, $shelter_id)
    {
        return $query->where('shelter_id', $shelter_id)->get()
            ->filter(function ($item) {
                return $item->shelter_staff_type_id == 1;
            });
    }

    public function scopeCareStaff($query, $shelter_id)
    {
        return $query->where('shelter_id', $shelter_id)->get()
            ->filter(function ($item) {
                return $item->shelter_staff_type_id == 2;
            });
    }

    public function scopeVetStaff($query, $shelter_id)
    {
        return $query->where('shelter_id', $shelter_id)->get()
            ->filter(function ($item) {
                if($item->shelter_staff_type_id == 3){
                    return $item;
                }
                
                if($item->shelter_staff_type_id == 4) {
                    return $item;
                }
            });
    }

    public function scopePersonelStaff($query, $shelter_id)
    {
        return $query->where('shelter_id', $shelter_id)->get()
            ->filter(function ($item) {
                return $item->shelter_staff_type_id == 5;
            });
    }

    public function euthanasia()
    {
        return $this->hasOne(Euthanasia::class);
    }

    public function shelterStaffType()
    {
        return $this->belongsTo(ShelterStaffType::class);
    }
}
