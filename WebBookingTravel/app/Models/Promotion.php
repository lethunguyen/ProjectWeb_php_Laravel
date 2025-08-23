<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'Promotion';
    protected $primaryKey = 'promotionID';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'description',
        'discountType',
        'discountValue',
        'startDate',
        'endDate',
        'isActive',
    ];
}
