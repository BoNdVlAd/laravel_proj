<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequests\ResetPasswordRequest;
use App\Http\Requests\ProfileRequests\SendResetLinkEmailRequest;
use App\Http\Requests\ProfileRequests\UserChangePasswordRequest;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileService $profileService
    )
    {
    }

    /**
     * @param UserChangePasswordRequest $userChangePasswordRequest
     * @return JsonResponse
     */
    public function changePassword(UserChangePasswordRequest $userChangePasswordRequest): JsonResponse
    {
        $data = $userChangePasswordRequest->getContent();
        $content = json_decode($data, true);

        return new JsonResponse(['message' => $this->profileService->changePassword($content)], 400);
    }

    /**
     * @param SendResetLinkEmailRequest $sendResetLinkEmailRequest
     * @return JsonResponse
     */
    public function sendResetLinkEmail(SendResetLinkEmailRequest $sendResetLinkEmailRequest): JsonResponse
    {
        $data = $sendResetLinkEmailRequest->getContent();
        $content = json_decode($data, true);

        return new JsonResponse(['message' => $this->profileService->sendResetLinkEmail($content)], 200);

    }

    /**
     * @param ResetPasswordRequest $resetPasswordRequest
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $resetPasswordRequest): JsonResponse
    {
        $data = $resetPasswordRequest->getContent();
        $content = json_decode($data, true);

        return new JsonResponse(['message' => $this->profileService->resetPassword($content)], 200);
    }
}
