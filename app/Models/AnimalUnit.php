<?php

namespace App\Models;

use App\Models\AnimalCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalUnit extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'latin-name'];

    public function animalCode()
    {
        return $this->hasOne(AnimalCode::class);
    }
}
