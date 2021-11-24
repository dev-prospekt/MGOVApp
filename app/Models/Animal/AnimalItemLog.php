<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalItemLog extends Model
{
    use HasFactory;

    public function animalItem()
    {
        return $this->belongsTo(AnimalItem::class);
    }
}
