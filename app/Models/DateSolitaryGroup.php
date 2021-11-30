<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateSolitaryGroup extends Model
{
    use HasFactory;

    protected $fillable = ['animal_item_id', 'solitary_or_group', 'start_date'];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function animalItem()
    {
        return $this->belongsTo(AnimalItem::class);
    }
}
