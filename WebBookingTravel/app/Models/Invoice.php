<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'Invoice';
    protected $primaryKey = 'invoiceID';
    public $timestamps = false;

    protected $fillable = [
        'bookingID',
        'amount',
        'details',
        'issueDate',
    ];

    public function booking() { return $this->belongsTo(Booking::class, 'bookingID', 'bookingID'); }
}
