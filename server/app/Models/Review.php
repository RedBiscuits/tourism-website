<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'stars',
        'tour_id',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
