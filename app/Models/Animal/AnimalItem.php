<?php

namespace App\Models\Animal;

use App\Models\Shelter\Shelter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AnimalItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function animal()
    {
        return $this->belongsTo(Animal::class)->with('animalSize');
    }

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function animalSizeAttributes()
    {
        return $this->belongsTo(AnimalSizeAttribute::class);
    }
}
