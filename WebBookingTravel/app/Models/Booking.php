<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'Booking';
    protected $primaryKey = 'bookingID';
    public $timestamps = false;

    protected $fillable = [
        'tourID',
        'userID',
        'bookingDate',
        'numAdults',
        'numChildren',
        'totalPrice',
        'status',
        'specialRequest',
    ];

    public function tour() { return $this->belongsTo(Tour::class, 'tourID', 'tourID'); }
    public function user() { return $this->belongsTo(User::class, 'userID', 'userID'); }
    public function checkout() { return $this->hasOne(Checkout::class, 'bookingID', 'bookingID'); }
    public function invoice() { return $this->hasOne(Invoice::class, 'bookingID', 'bookingID'); }
}
