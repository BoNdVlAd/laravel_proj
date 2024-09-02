<?php

namespace App\Http\Controllers\Swagger;

/**
 *     @OA\Schema(
 *         schema="User",
 *         type="object",
 *         title="User",
 *         @OA\Property(
 *              property="id",
 *              type="integer",
 *              example=1
 *          ),
*           @OA\Property(
*               property="name",
*               type="string",
*               example="Tom"
*           ),
*           @OA\Property(
*               property="email",
*               type="string",
*               example="Tom@gmail.com"
*           ),
*           @OA\Property(
*               property="created_at",
*               type="string",
*               example="2024-08-15T08:55:40.000000Z"
*           ),
*           @OA\Property(
*               property="updated_at",
*               type="string",
*               example="2024-08-15T08:55:40.000000Z"
*           ),
 *   )
 */
class User
{

}
