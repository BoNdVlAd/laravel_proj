<?php

namespace App\Services;

use App\Http\Requests\ProfileRequests\ResetPasswordRequest;
use App\Http\Requests\ProfileRequests\SendResetLinkEmailRequest;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class ProfileService
{
    /**
     * @param $data
     * @return string
     */
    public function changePassword(array $data): string
    {
        $user = auth()->user();

        if (!password_verify($data['old_password'], $user->password)) {
            return 'Wrong old password';
        }

        $user->password = $data['new_password'];

        $user->save();

        return 'Password has been changed';
    }

    /**
     * @param $data
     * @return string
     */
    public function sendResetLinkEmail($data): string
    {
        $status = Password::sendResetLink($data);

        if ($status === Password::RESET_LINK_SENT) {
            return __($status);
        } else {
            abort(404, 'email could not be sent');
        }
    }

    /**
     * @param $data
     * @return string
     */
    public function resetPassword($data): string
    {
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->password = $password;
                
                $user->save();
            }
        );

        if ($status === Password::RESET_LINK_SENT) {
            return __($status);
        } else {
            abort(404, 'email could not be sent');
        }
    }
}
