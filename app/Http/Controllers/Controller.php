<?php

namespace App\Http\Controllers;

/**
 *  @OA\Info(
 *      version="1.0.0",
 *      title="First_proj",
 *  )
 * @OA\SecurityScheme(
 *          securityScheme="bearerAuth",
 *          type="http",
 *          scheme="bearer",
 *          bearerFormat="JWT",
 *          description="Enter JWT token. Example: 'Bearer {token}'"
 *      )
 *
 */
abstract class Controller
{
}
