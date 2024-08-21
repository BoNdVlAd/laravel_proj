<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequests\UserCreateRequest;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use App\Models\User;
use App\Services\MediaService;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function __construct(
        private UserService $userService,
        private MediaService $mediaService
    )
    {
    }

    /**
     *  @OA\Get(
     *      path="/api/users",
     *      summary="Get a list of users",
     *      tags={"Users"},
     *      @OA\Response(response=200, description="List of users"),
     *  )
     *
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        $queryParams = request()->query();
        $users = $this->userService->getAllUsers($queryParams);

        return new JsonResponse($users, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     operationId="getUserByID",
     *     tags={"Users"},
     *     summary="Get a specific user",
     *     description="Returns user data",
     *     @OA\Parameter(
     *         name="id",
     *         description="User's id",
     *         required=true,
     *         in="path"
     *     ),
     *     @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                   property="id",
     *                   type="integer",
     *                   example=1
     *               ),
     *               @OA\Property(
     *                   property="name",
     *                   type="string",
     *                   example="Tom Cruise"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   type="string",
     *                   example="tom@gmail.com"
     *               )
     *           )
     *       ),
     *       @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *       ),
     *       @OA\Response(
     *           response=500,
     *           description="Internal server error"
     *       )
     * )
     *
     * @param User $user
     * @return JsonResponse
     *
     */
    public function getUser(User $user): JsonResponse
    {
        $user = $this->userService->getUserById($user);

        return new JsonResponse($user, Response::HTTP_OK);
    }


    /**
     * @OA\Post(
     *     path="/api/users",
     *     operationId="createUser",
     *     tags={"Users"},
     *     summary="Create new User",
     *     description="Returns user data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Tom Cruise"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 example="tom@gmail.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="Tom Cruise"
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="tom@gmail.com"
     *              ),
     *              @OA\Property(
     *                  property="updated_at",
     *                  type="string",
     *                  example="tom@2024-08-21T12:42:33.000000Z.com"
     *              ),
     *              @OA\Property(
     *                   property="created_at",
     *                   type="string",
     *                   example="tom@2024-08-21T12:42:33.000000Z.com"
     *               ),
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example=1
     *              )
     *
     *          )
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     * @param UserCreateRequest $userCreateRequest
     * @return JsonResponse
     *
     */
    public function createUser(UserCreateRequest $userCreateRequest): JsonResponse
    {
        $data = $userCreateRequest->getContent();
        $content = json_decode($data, true);

        $user = $this->userService->createUser($content);

        return new JsonResponse($user, Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @param UserUpdateRequest $userUpdateRequest
     * @return JsonResponse
     */
    public function updateUser(User $user, UserUpdateRequest $userUpdateRequest): JsonResponse
    {
        $data = $userUpdateRequest->getContent();
        $content = json_decode($data, true);

        $user = $this->userService->updateUser($user, $content);

        return new JsonResponse($user, Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function deleteUser(User $user): JsonResponse
    {
        $response = $this->userService->deleteUser($user);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function checkManager(): JsonResponse
    {
        return new JsonResponse(['role is Manager'=>$this->userService->checkRole('manager')], 400);
    }

    /**
     * @return JsonResponse
     */
    public function checkCustomer(): JsonResponse
    {
        return new JsonResponse(['role is Customer'=>$this->userService->checkRole('customer')], 400);
    }

    /**
     * @return JsonResponse
     */
    public function checkChef(): JsonResponse
    {
        return new JsonResponse(['role is Chef'=>$this->userService->checkRole('chef')], 400);
    }

    /**
     * @return JsonResponse
     */
    public function checkWaiter(): JsonResponse
    {
        return new JsonResponse(['role is Waiter'=>$this->userService->checkRole('waiter')], 400);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function editRoleToManager(): JsonResponse
    {
        return new JsonResponse(['message'=>$this->userService->editRole('manager')], 400);

    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function editRoleToCustomer(): JsonResponse
    {
        return new JsonResponse(['message'=>$this->userService->editRole('customer')], 400);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function editRoleToWaiter(): JsonResponse
    {
        return new JsonResponse(['message'=>$this->userService->editRole('waiter')], 400);
    }

    /**
     * @return JsonResponse
     */
    public function editRoleToChef(): JsonResponse
    {
        return new JsonResponse(['message' => $this->userService->editRole('chef')], 400);
    }

    /**
     * @param User $model
     * @param Request $uploadFileRequest
     * @return JsonResponse
     */
    public function createMedia(User $model, Request $uploadFileRequest): JsonResponse
    {
        return new JsonResponse($this->mediaService->createMedia($model, $uploadFileRequest), Response::HTTP_CREATED);
    }

    /**
     * @return JsonResponse
     */
    public function getMedia(User $model): JsonResponse
    {
        $allMedia = $this->mediaService->getAllMedia($model);

        return new JsonResponse($allMedia, Response::HTTP_OK);
    }
}


