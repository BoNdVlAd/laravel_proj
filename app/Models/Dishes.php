<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Dishes extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function dishes(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return MorphOne
     */
    public function gallery(): MorphOne
    {
        return $this->morphOne(Gallery::class, 'galleryable');
    }
}
