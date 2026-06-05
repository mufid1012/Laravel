<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image_path',
        'download_url',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
