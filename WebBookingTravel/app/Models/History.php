<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'History';
    protected $primaryKey = 'historyID';
    public $timestamps = false;

    protected $fillable = [
        'userID',
        'tourID',
        'actionType',
        'timestamp',
    ];

    public function user() { return $this->belongsTo(User::class, 'userID', 'userID'); }
    public function tour() { return $this->belongsTo(Tour::class, 'tourID', 'tourID'); }
}
