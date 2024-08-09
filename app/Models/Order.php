<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function dishes(): HasMany
    {
        return $this->hasMany(Dishes::class);
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
