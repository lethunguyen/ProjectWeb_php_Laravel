<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $table = 'Checkout';
    protected $primaryKey = 'checkoutID';
    public $timestamps = false;

    protected $fillable = [
        'bookingID',
        'paymentStatus',
        'paymentDate',
        'amount',
    ];

    public function booking() { return $this->belongsTo(Booking::class, 'bookingID', 'bookingID'); }
}
