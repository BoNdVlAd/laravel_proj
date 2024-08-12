<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Dishes;

class Order extends Model
{
    use HasFactory;

    /**
     * @return BelongsToMany
     */
    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dishes::class, 'dish_order');
    }

    /**
     * @return void
     */
    public function calculateTotalPrice(): void
    {
        $totalPrice = $this->dishes->sum('price');
        $this->total_price = $totalPrice;
        $this->save();
    }
}
