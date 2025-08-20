<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = ['name', 'price', 'days', 'description', 'category_id', 'image_path'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
