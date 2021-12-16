<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalItemCareEndType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function careEnd()
    {
        return $this->hasOne(AnimalItemCareEnd::class);
    }
    public function animalItem()
    {
        return $this->hasOne(AnimalItem::class);
    }
}
