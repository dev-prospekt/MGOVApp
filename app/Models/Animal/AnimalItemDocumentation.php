<?php

namespace App\Models\Animal;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\MediaCollections\Models\Media;


class AnimalItemDocumentation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['animal_item_id', 'state_recive', 'state_recive_desc', 'state_found', 'state_found_desc', 'state_reason', 'state_reason_desc', 'seized_doc'];

    public function animalMark()
    {
        return $this->hasOne(AnimalMark::class)->with('animalMarkType');
    }

    public function animalItem()
    {
        return $this->belongsTo(AnimalItem::class);
    }
    public function stateFound()
    {
        return $this->belongsTo(AnimalItemDocumentationStateType::class, 'state_found', 'id');
    }
    public function stateRecived()
    {
        return $this->belongsTo(AnimalItemDocumentationStateType::class, 'state_recive', 'id');
    }
    public function stateReason()
    {
        return $this->belongsTo(AnimalItemDocumentationStateType::class, 'state_reason', 'id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(150)
              ->height(100);
    }
}
