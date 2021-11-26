<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateRange extends Model
{
    use HasFactory;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'hibern_start' => 'date',
        'hibern_end' => 'date',
    ];

    public function animalItem()
    {
        return $this->belongsTo(AnimalItem::class);
    }
}
