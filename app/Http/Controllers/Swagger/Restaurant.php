<?php

namespace App\Http\Controllers\Swagger;

/**
 *     @OA\Schema(
 *         schema="Restaurant",
 *         type="object",
 *         title="Restaraunt",
 *         @OA\Property(
 *              property="id",
 *              type="integer",
 *              example=1
 *          ),
 *          @OA\Property(
 *              property="name",
 *              type="string",
 *              example="Asador Etxebarri"
 *          ),
 *          @OA\Property(
 *              property="country",
 *              type="string",
 *              example="France"
 *          ),
 *          @OA\Property(
 *                  property="latitude",
 *                  type="number",
 *                  format="float",
 *                  example=50.42297
 *          ),
 *          @OA\Property(
 *                  property="longitude",
 *                  type="number",
 *                  format="float",
 *                  example=30.24416
 *          ),
 *          @OA\Property(
 *              property="created_at",
 *              type="string",
 *              example="2024-08-15T08:55:40.000000Z"
 *          ),
 *          @OA\Property(
 *              property="updated_at",
 *              type="string",
 *              example="2024-08-15T08:55:40.000000Z"
 *          ),

 *   )
 */
class Restaurant
{

}
