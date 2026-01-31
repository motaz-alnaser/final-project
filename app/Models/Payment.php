<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id', 
        'user_id', 
        'amount', 
        'currency',
        'stripe_payment_intent_id',
        'stripe_payment_method_id',
        'status', 
        'receipt_url',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payment()
{
    return $this->hasOne(Payment::class);
}

}