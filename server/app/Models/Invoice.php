<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'amount',
        'currency',
        'status',
        'invoice_number',
        'invoice_key',
        'payment_method',
        'reservation_id',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
