<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *     @OA\Schema(
 *         schema="Order",
 *         type="object",
 *         title="Order",
 *         @OA\Property(
 *          property="user_id",
 *          type="integer",
 *          example=3
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="boolean",
 *          example=false
 *      ),
 *      @OA\Property(
 *           property="total_price",
 *              type="integer",
 *              example=600
 *      ),
 *      @OA\Property(
 *          property="payment_method",
 *          type="string",
 *          example="cash"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          example="2024-08-21T13:40:26.000000Z"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="string",
 *          example="2024-08-21T13:40:26.000000Z"
 *      ),
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=36
 *      ),
 *      @OA\Property(
 *          property="dishes",
 *          type="array",
 *          @OA\Items(
 *              ref="#/components/schemas/Dishes"
 *          )
 *      ),
 *   )
 */

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
