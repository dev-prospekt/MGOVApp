<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reports extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['date'];
    protected $casts = ['date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }
}
