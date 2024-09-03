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
     *  @OA\Patch(
     *      path="/api/auth/change_password",
     *      summary="change password",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                   property="old_password",
     *                   type="string",
     *                   example="some_password"
     *               ),
     *               @OA\Property(
     *                    property="new_password",
     *                    type="string",
     *                    example="password"
     *               ),
     *           )
     *       ),
     *      @OA\Response(
     *           response="200",
     *           description="Password has been changed",
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
     * @param UserChangePasswordRequest $userChangePasswordRequest
     * @return JsonResponse
     */
    public function changePassword(UserChangePasswordRequest $userChangePasswordRequest): JsonResponse
    {
        $data = $userChangePasswordRequest->getContent();
        $content = json_decode($data, true);

        return new JsonResponse(['message' => $this->profileService->changePassword($content)], 200);
    }

    /**
     *  @OA\Patch(
     *      path="/api/reset/password/email",
     *      summary="send email with a link for reseting password",
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
     *           )
     *       ),
     *      @OA\Response(
     *           response="200",
     *           description="We have emailed your password reset link.",
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
     *  @OA\Post(
     *      path="/api/reset/password",
     *      summary="change password",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                   property="token",
     *                   type="string",
     *                   example="5ad66c49f77e76915da6ac9740e7e3dd580b3efec295e7472fe3ce0f468ec722"
     *               ),
     *               @OA\Property(
     *                    property="email",
     *                    type="string",
     *                    example="Tom@gmail.com"
     *               ),
     *               @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="password"
     *               ),
     *               @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     example="password"
     *               ),
     *           )
     *       ),
     *      @OA\Response(
     *           response="200",
     *           description="Your password has been reset.",
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
