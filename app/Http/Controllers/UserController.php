<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequests\UserCreateRequest;
use App\Http\Requests\UserRequests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param UserCreateRequest $userCreateRequest
     * @return JsonResponse
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
     * @param Request $userChangePasswordRequest
     * @return JsonResponse
     */
    public function changePassword(Request $userChangePasswordRequest): JsonResponse
    {
        $data = $userChangePasswordRequest->getContent();
        $content = json_decode($data, true);

        return new JsonResponse(['message' => $this->userService->changePassword($content)], 400);
    }
}


