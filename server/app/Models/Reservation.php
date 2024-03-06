<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tour_id',
        'name',
        'email',
        'phone',
        'date',
        'hotel_name',
        'room_uid',
        'num_people',
        'total_amount',
        'invoice_id'
    ];

    protected $casts = [
        'uid' => 'string',
        'date' => 'date'
    ];


    public function getStatusAttribute()
    {
        return $this->total_amount - $this->amount_paid < 5.01;
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = Str::substr(md5(uniqid()), 0, 12); // Generate 12-character unique UID
        });
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
