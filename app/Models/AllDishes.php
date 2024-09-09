<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllDishes extends Model
{
    use HasFactory;

    protected $casts = [
        'nutritional_value' => 'array'
    ];

    protected $fillable = ['title', 'image_url', 'short_description', 'description', 'weight', 'calories', 'nutritional_value'];
}
