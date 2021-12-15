<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalItemCareEnd extends Model
{
    use HasFactory;

    protected $fillable = ['animal_item_care_end_type_id', 'release_location', 'permanent_keep_name', 'care_end_other', 'care_end_description'];

    public function careEndType()
    {
        return $this->belongsTo(AnimalItemCareEndType::class, 'animal_item_care_end_type_id');
    }

    public function animalItem()
    {
        return $this->belongsTo(AnimalItem::class);
    }
}
