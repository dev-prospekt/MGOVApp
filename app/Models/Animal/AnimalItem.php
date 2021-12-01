<?php

namespace App\Models\Animal;

use App\Models\DateRange;
use App\Models\FounderData;
use App\Models\DateFullCare;
use App\Models\DateSolitaryGroup;

use App\Models\Shelter\Shelter;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Animal\AnimalGroup;
use App\Models\ShelterAnimalPrice;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    use \Bkwld\Cloner\Cloneable;

    protected $casts = [
        'animal_date_found' => 'date',
        'date_seized_animal' => 'date',
    ];

    protected $cloneable_relations = ['animalMarks', 'animalItemLogs', 'dateRange', 'dateSolitaryGroups', 'dateFullCare', 'euthanasia'];

    public function animal()
    {
        return $this->belongsTo(Animal::class)->with('animalSize', 'animalCategory');
    }

    public function animalGroup()
    {
        return $this->belongsTo(AnimalGroup::class);
    }

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function animalSizeAttributes()
    {
        return $this->belongsTo(AnimalSizeAttribute::class);
    }

    public function dateRange()
    {
        return $this->hasOne(DateRange::class);
    }

    public function dateSolitaryGroups()
    {
        return $this->hasMany(DateSolitaryGroup::class);
    }

    public function dateFullCare()
    {
        return $this->hasMany(DateFullCare::class);
    }

    public function animalMarks()
    {
        return $this->hasMany(AnimalMark::class)->with('animalMarkType');
    }

    public function shelterAnimalPrice()
    {
        return $this->hasOne(ShelterAnimalPrice::class);
    }

    public function animalItemLogs()
    {
        return $this->hasMany(AnimalItemLog::class)->with('logType')->latest();
    }

    public function founder()
    {
        return $this->belongsTo(FounderData::class);
    }

    public function euthanasia()
    {
        return $this->hasOne(Euthanasia::class);
    }
}
