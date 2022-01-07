<?php

namespace App\Models\Animal;

use App\Models\Shelter\ShelterStaff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Euthanasia extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['shelter_staff_id', 'price'];

    public function animalItem()
    {
        return $this->belongsTo(AnimalItem::class);
    }

    public function shelterStaff()
    {
        return $this->belongsTo(ShelterStaff::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(150)
              ->height(100);
    }
}
