<?php

namespace App\Models;

use App\Models\AnimalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalCode extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function animalUnit()
    {
        return $this->belongsTo(AnimalUnit::class);
    }
}
