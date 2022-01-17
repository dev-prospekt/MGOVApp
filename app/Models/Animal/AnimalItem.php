<?php

namespace App\Models\Animal;

use DateTimeInterface;
use App\Models\DateRange;
use App\Models\FounderData;
use App\Models\DateFullCare;

use App\Models\Shelter\Shelter;
use App\Models\DateSolitaryGroup;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Animal\AnimalGroup;
use App\Models\ShelterAnimalPrice;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;
    use \Bkwld\Cloner\Cloneable;

    /* protected $cloneable_file_attributes = ['media']; */
    protected $guarded = [];

    protected $fillable = ['animal_code'];

    protected $casts = [
        'animal_date_found' => 'date',
        'date_seized_animal' => 'date',
    ];


    protected $cloneable_relations = ['animalDocumentation', 'dateRange', 'dateSolitaryGroups', 'dateFullCare', 'euthanasia', 'shelterAnimalPrice'];

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

    public function shelterAnimalPrice()
    {
        return $this->hasOne(ShelterAnimalPrice::class);
    }

    public function latestAnimalItemLogs()
    {
        return $this->hasMany(AnimalItemLog::class)->with('logType')->latest();
    }

    public function animalItemLogs()
    {
        return $this->hasMany(AnimalItemLog::class)->with('logType');
    }

    public function founder()
    {
        return $this->belongsTo(FounderData::class);
    }

    public function broughtAnimal()
    {
        return $this->belongsTo(FounderData::class, 'brought_animal_id');
    }

    public function euthanasia()
    {
        return $this->hasOne(Euthanasia::class);
    }
    public function animalDocumentation()
    {
        return $this->hasOne(AnimalItemDocumentation::class);
    }
    
    public function careEnd()
    {
        return $this->hasOne(AnimalItemCareEnd::class);
    }
}
