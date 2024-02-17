<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tour extends Model implements HasMedia
{
    use HasFactory ,InteractsWithMedia;

    protected $fillable = [
        'description',
        'location',
        'name',
        'includes',
        'excludes',
        'duration'
    ];


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function setIncludesAttribute($value)
    {
        $this->attributes['includes'] = json_encode($value);
    }

    public function getIncludesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setExcludesAttribute($value)
    {
        $this->attributes['excludes'] = json_encode($value);
    }

    public function getExcludesAttribute($value)
    {
        return json_decode($value, true);
    }
}
