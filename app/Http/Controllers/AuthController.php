<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     *  @OA\Post(
     *      path="/api/auth/login",
     *      summary="login",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                   property="email",
     *                   type="string",
     *                   example="Tom@gmail.com"
     *               ),
     *               @OA\Property(
     *                    property="password",
     *                    type="string",
     *                    example="password"
     *               ),
     *           )
     *       ),
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="access_token",
     *                  type="string",
     *                  example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZmlyc3RfcHJvai50ZXN0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzI0MzEyMDY4LCJleHAiOjE3MjQzOTg0NjgsIm5iZiI6MTcyNDMxMjA2OCwianRpIjoiTE1KbFZlakVzVERzZUYwOCIsInN1YiI6IjMiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.IqfkCQhq0JjIDzO2TBHR7vuGLmQpL_QiAtuTyQl6mKA"
     *               ),
     *               @OA\Property(
     *                     property="token_type",
     *                     type="string",
     *                     example="bearer"
     *               ),
     *               @OA\Property(
     *                      property="expires_in",
     *                      type="integer",
     *                      example=86400
     *               ),
     *           )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     *  @OA\Get(
     *      path="/api/auth/me",
     *      summary="me",
     *      tags={"Auth"},
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example=3
     *               ),
     *               @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Tom"
     *               ),
     *               @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      example="Tom@gmail.com"
     *               ),
     *               @OA\Property(
     *                       property="created_at",
     *                       type="string",
     *                       example="2024-08-15T07:05:58.000000Z"
     *               ),
     *               @OA\Property(
     *                       property="updated_at",
     *                       type="string",
     *                       example="2024-08-15T07:05:58.000000Z"
     *               ),
     *           )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return new JsonResponse(auth()->user());
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return new JsonResponse(['message' => 'Successfully logged out']);
    }

    /**
     *  @OA\Post(
     *      path="/api/auth/refresh",
     *      summary="refresh token",
     *      tags={"Auth"},
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="access_token",
     *                  type="string",
     *                  example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZmlyc3RfcHJvai50ZXN0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzI0MzEyMDY4LCJleHAiOjE3MjQzOTg0NjgsIm5iZiI6MTcyNDMxMjA2OCwianRpIjoiTE1KbFZlakVzVERzZUYwOCIsInN1YiI6IjMiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.IqfkCQhq0JjIDzO2TBHR7vuGLmQpL_QiAtuTyQl6mKA"
     *               ),
     *               @OA\Property(
     *                     property="token_type",
     *                     type="string",
     *                     example="bearer"
     *               ),
     *               @OA\Property(
     *                      property="expires_in",
     *                      type="integer",
     *                      example=86400
     *               ),
     *           )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return new JsonResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
