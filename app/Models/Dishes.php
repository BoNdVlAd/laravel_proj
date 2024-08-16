<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Order;

class Dishes extends Model
{
    use HasFactory;

    protected $casts = [
        'recipe' => 'array'
    ];

    /**
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'dish_order');
    }

    /**
     * @return MorphOne
     */
    public function gallery(): MorphOne
    {
        return $this->morphOne(Gallery::class, 'galleryable');
    }
}
