<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class AnimalMark extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['animal_marks_type_id', 'name'];

    public function animalMarkTypes()
    {
        return $this->belongsTo(AnimalMarkType::class, 'animal_marks_type_id');
    }
    public function animalItem()
    {
        return $this->hasMany(AnimalItem::class);
    }
}
