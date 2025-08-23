<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'Admin';
    protected $primaryKey = 'adminID';
    public $timestamps = false;

    protected $fillable = [
        'userName',
        'password',
        'email',
        'role',
        'createdDate',
    ];
}
