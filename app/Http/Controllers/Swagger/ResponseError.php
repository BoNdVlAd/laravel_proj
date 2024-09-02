<?php

namespace App\Http\Controllers\Swagger;

/**
 *      @OA\Schema(
 *          schema="Error",
 *          type="object",
 *          title="Error",
 *          @OA\Response(
 *              response=400,
 *              description="Invalid input"
 *          ),
 *          @OA\Response(
 *              response=500,
 *              description="Internal server error"
 *          )
 *      )
 */
class ResponseError
{

}
