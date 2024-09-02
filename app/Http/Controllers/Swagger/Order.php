<?php

namespace App\Http\Controllers\Swagger;

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
class Order
{

}
