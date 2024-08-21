<?php

namespace App\Http\Controllers;

/**
 *  @OA\Info(
 *      version="1.0.0",
 *      title="First_proj",
 *  )
 *
 *  @OA\Get(
 *      path="/",
 *      description="Home page",
 *      @OA\Response(response="default", description="Welcome page")
 * )
 */
abstract class Controller
{
}
