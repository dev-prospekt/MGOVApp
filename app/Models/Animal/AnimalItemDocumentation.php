<?php

namespace App\Models\Animal;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AnimalItemDocumentation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['animal_item_id', 'state_recive', 'state_recive_desc', 'state_found', 'state_found_desc', 'state_reason', 'state_reason_desc'];

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
}
