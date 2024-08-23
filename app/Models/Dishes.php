<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @OA\Components(
 *     @OA\Schema(
 *         schema="Dishes",
 *         type="object",
 *         title="Dishes",
 *         @OA\Property(
 *             property="id",
 *             type="integer",
 *             description="Dishes ID",
 *             example=1
 *         ),
 *         @OA\Property(
 *             property="title",
 *             type="string",
 *             description="title of dishes",
 *             example="Borsch"
 *         ),
 *         @OA\Property(
 *             property="description",
 *             type="string",
 *             description="Dishes description",
 *             example="Very tasty"
 *         ),
 *         @OA\Property(
 *             property="price",
 *             type="integer",
 *             description="Dishes price",
 *             example=100
 *         ),
 *         @OA\Property(
 *              property="recipe",
 *              type="array",
 *              @OA\Items(
 *                  type="object",
 *                  @OA\Property(
 *                      property="id",
 *                      type="integer",
 *                      example=1
 *                  ),
 *                  @OA\Property(
 *                      property="qty",
 *                      type="integer",
 *                      example=5
 *                  )
 *             ),
 *             example={{"id": 1, "qty": 5}, {"id": 2, "qty": 3}}
 *         ),
 *         @OA\Property(
 *              property="created_at",
 *              type="string",
 *              example="2024-08-15T08:55:40.000000Z"
 *         ),
 *         @OA\Property(
 *              property="updated_at",
 *              type="string",
 *              example="2024-08-15T08:55:40.000000Z"
 *         ),
 *         @OA\Property(
 *              property="order_id",
 *              type="integer",
 *              example=1
 *         ),
 *     )
 * )
 */

class Dishes extends Model
{
    use HasFactory;

    protected $casts = [
        'recipe' => 'array'
    ];

    /**
     * @return BelongsTo
     */
    public function menu(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'dish_menu');
    }

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
