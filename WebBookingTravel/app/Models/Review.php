<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'Review';
    protected $primaryKey = 'reviewID';
    public $timestamps = false;

    protected $fillable = [
        'tourID',
        'userID',
        'rating',
        'comment',
        'createdDate',
    ];

    public function tour() { return $this->belongsTo(Tour::class, 'tourID', 'tourID'); }
    public function user() { return $this->belongsTo(User::class, 'userID', 'userID'); }
}
