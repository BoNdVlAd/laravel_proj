<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\UserCreateRequest;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use App\Models\Media;
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
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          ),
     *          description="Page number"
     *      ),
     *      @OA\Parameter(
     *          name="perPage",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              example=3
     *          ),
     *          description="NUmber of elements on page"
     *      ),
     *      @OA\Parameter(
     *            name="name",
     *            in="query",
     *            required=false,
     *            @OA\Schema(
     *                type="string",
     *                example="Tom"
     *            ),
     *            description="Filter by name"
     *        ),
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="gmail"
     *          ),
     *          description="Filter by email"
     *      ),
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      ref="#/components/schemas/User"
     *                  )
     *               ),
     *               @OA\Property(
     *                  property="pagintaion",
     *                  type="object",
     *                  ref="#/components/schemas/Pagination"
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
     * @OA\Patch(
     *     path="/api/users/update/{id}",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     summary="Update specific User",
     *     description="Returns user data",
     *     @OA\Parameter(
     *           name="id",
     *           description="User's id",
     *           required=true,
     *           in="path"
     *     ),
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
     *              ref="#/components/schemas/User"
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
     *
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
     *  @OA\Delete(
     *  path="/api/users/delete/{id}",
     *  operationId="deleteUser",
     *  tags={"Users"},
     *  summary="Delete the User",
     *  description="Returns response",
     *      @OA\Parameter(
     *          name="id",
     *          description="User's id",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User was removed"
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
     * @param User $user
     * @return JsonResponse
     *
     */
    public function deleteUser(User $user): JsonResponse
    {
        $response = $this->userService->deleteUser($user);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/users/check_role/{id}",
     *     operationId="checkUserRoleByID",
     *     tags={"Users"},
     *     summary="Get a specific user role",
     *     description="message with user role",
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
     *                   property="message",
     *                   type="string",
     *                   example="User role is waiter"
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
    public function checkRole(User $user): JsonResponse
    {
        $response = $this->userService->checkRole($user);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }

    /**
     * @OA\Patch(
     *     path="/api/users/role_manager",
     *     operationId="editUserRoleToManager",
     *     tags={"Users"},
     *     summary="Edit user role to manager",
     *     description="Returns message with user new role",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *            response=200,
     *            description="Successful operation",
     *            @OA\JsonContent(
     *                type="object",
     *                @OA\Property(
     *                    property="message",
     *                    type="string",
     *                    example="Role has been changed"
     *                )
     *            )
     *        ),
     *     @OA\Response(
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
    public function editRoleToManager(): JsonResponse
    {
        return new JsonResponse(['message'=>$this->userService->editRole('manager')], 200);

    }

    /**
     * @OA\Patch(
     *     path="/api/users/role_customer",
     *     operationId="editUserRoleToCustomer",
     *     tags={"Users"},
     *     summary="Edit user role to customer",
     *     description="Returns message with user new role",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *            response=200,
     *            description="Successful operation",
     *            @OA\JsonContent(
     *                type="object",
     *                @OA\Property(
     *                    property="message",
     *                    type="string",
     *                    example="Role has been changed"
     *                )
     *            )
     *        ),
     *     @OA\Response(
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
    public function editRoleToCustomer(): JsonResponse
    {
        return new JsonResponse(['message'=>$this->userService->editRole('customer')], 400);
    }

    /**
     * @OA\Patch(
     *     path="/api/users/role_waiter",
     *     operationId="editUserRoleToWaiter",
     *     tags={"Users"},
     *     summary="Edit user role to waiter",
     *     description="Returns message with user new role",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *            response=200,
     *            description="Successful operation",
     *            @OA\JsonContent(
     *                type="object",
     *                @OA\Property(
     *                    property="message",
     *                    type="string",
     *                    example="Role has been changed"
     *                )
     *            )
     *        ),
     *     @OA\Response(
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
    public function editRoleToWaiter(): JsonResponse
    {
        return new JsonResponse(['message'=>$this->userService->editRole('waiter')], 400);
    }

    /**
     * @OA\Patch(
     *     path="/api/users/role_chef",
     *     operationId="editUserRoleToChef",
     *     tags={"Users"},
     *     summary="Edit user role to chef",
     *     description="Returns message with user new role",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *            response=200,
     *            description="Successful operation",
     *            @OA\JsonContent(
     *                type="object",
     *                @OA\Property(
     *                    property="message",
     *                    type="string",
     *                    example="Role has been changed"
     *                )
     *            )
     *        ),
     *     @OA\Response(
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
    public function editRoleToChef(): JsonResponse
    {
        return new JsonResponse(['message' => $this->userService->editRole('chef')], 400);
    }

    /**
     * @OA\Post(
     *     path="/api/media/users/{id}",
     *     operationId="createMediaForUsers",
     *     tags={"Users"},
     *     summary="Create Media for users",
     *     @OA\Parameter(
     *         name="id",
     *         description="User's id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="file1",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="file2",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Media uploaded successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     * @param User $model
     * @param Request $uploadFileRequest
     * @return JsonResponse
     *
     */
    public function createMedia(User $model, Request $uploadFileRequest): JsonResponse
    {
        return new JsonResponse($this->mediaService->createMedia($model, $uploadFileRequest), Response::HTTP_CREATED);
    }


    /**
     * @OA\Get(
     *     path="/api/media/users/{id}",
     *     operationId="getMediaForUser",
     *     tags={"Users"},
     *     summary="Get media from specific user",
     *     @OA\Parameter(
     *         name="id",
     *         description="User's id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(
     *               type="array",
     *               @OA\Items(
     *                  ref="#/components/schemas/Media"
     *               )
     *           )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param User $model
     * @return JsonResponse
     *
     */
    public function getMedia(User $model): JsonResponse
    {
        $allMedia = $this->mediaService->getAllMedia($model);

        return new JsonResponse($allMedia, Response::HTTP_OK);
    }

}


