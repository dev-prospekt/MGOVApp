<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['date'];
    protected $casts = ['date' => 'date'];
}
