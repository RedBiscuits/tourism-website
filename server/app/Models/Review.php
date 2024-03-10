<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'stars',
        'tour_id',
        'deleted_at'
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
