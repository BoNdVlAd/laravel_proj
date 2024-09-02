<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
