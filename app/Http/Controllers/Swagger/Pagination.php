<?php

namespace App\Http\Controllers\Swagger;

/**
*     @OA\Schema(
*         schema="Pagination",
*         type="object",
*         title="Pagination",
*           @OA\Property(
*               property="total",
*               type="integer",
*               example=23
*           ),
*           @OA\Property(
*               property="perPage",
*               type="integer",
*               example=10
*           ),
*            @OA\Property(
*               property="currentPage",
*               type="integer",
*               example=1
*           ),
*            @OA\Property(
*               property="lastPage",
*               type="integer",
*               example=3
*           ),
 *           @OA\Property(
 *                property="from",
 *                type="integer",
 *                example=1
 *           ),
 *           @OA\Property(
 *                property="to",
 *                type="integer",
 *                example=10
 *           ),
 *   )
 */
class Pagination
{

}
