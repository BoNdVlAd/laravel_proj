<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\UserCreate;
use App\Http\Requests\UserRequests\UserUpdate;
use App\Models\User;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return new JsonResponse($users, Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function getUser(User $user): JsonResponse
    {
        $user = $this->userService->getUserById($user);

        return new JsonResponse($user, Response::HTTP_OK);
    }

    /**
     * @param UserCreate $userCreateRequest
     * @return JsonResponse
     */
    public function createUser(UserCreate $userCreateRequest): JsonResponse
    {
        $data = $userCreateRequest->getContent();
        $content = json_decode($data, true);

        $user = $this->userService->createUser($content);

        return new JsonResponse($user, Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @param UserUpdate $userUpdateRequest
     * @return JsonResponse
     */
    public function updateUser(User $user, UserUpdate $userUpdateRequest): JsonResponse
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
    public function deleteUser(User $user)
    {
        $response = $this->userService->deleteUser($user);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }
}


