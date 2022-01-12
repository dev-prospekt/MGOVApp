<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Animal\AnimalItemCareEnd;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
