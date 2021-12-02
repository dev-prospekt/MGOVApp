<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Bkwld\Cloner\Cloneable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class AnimalMark extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['animal_mark_type_id', 'animal_item_documentatation_id', 'animal_mark_note'];

    public function animalMarkType()
    {
        return $this->belongsTo(AnimalMarkType::class, 'animal_mark_type_id');
    }
    public function animalItemDocumentation()
    {
        return $this->belongsTo(AnimalItemDocumentation::class, 'animal_item_documentatation_id');
    }
}
