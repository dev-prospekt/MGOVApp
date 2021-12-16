<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelterAnimalPrice extends Model
{
    use HasFactory;

    protected $fillable = ['animal_item_id', 'hibern', 'full_care', 'solitary_price', 'group_price', 'total_price'];

    public function animalItems()
    {
        return $this->belongsTo(AnimalItem::class);
    }
}
