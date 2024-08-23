<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**

 *     @OA\Schema(
 *         schema="Product",
 *         type="object",
 *         title="Product",
 *         @OA\Property(
 *             property="id",
 *             type="integer",
 *             description="Product ID",
 *             example=1
 *         ),
 *         @OA\Property(
 *             property="title",
 *             type="string",
 *             description="title of product",
 *             example="carrot"
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
 *              property="weight",
 *              type="integer",
 *              example=2
 *         ),
 *     )
 */
class Product extends Model
{
    use HasFactory;
}
