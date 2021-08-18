<?php

namespace App\Models;

use App\Models\AnimalCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalUnit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }
}
