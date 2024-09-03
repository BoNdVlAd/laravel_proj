<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Http\JsonResponse;
use function Laravel\Prompts\password;

class TwoFactorAuth extends Controller
{
    public function generate2FASecret()
    {
        $google2fa = new Google2FA();
        $user = auth()->user();
        $user->google2fa_secret = $google2fa->generateSecretKey();
        $user->save();

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        return response()->json(['qr_code_url' => $qrCodeUrl]);
    }

    public function verify2FACode(Request $request): JsonResponse
    {
        $google2fa = new Google2FA();
        $user = auth()->user();

        if ($google2fa->verifyKey($user->google2fa_secret, $request->input('code'))) {

            return response()->json(['message' => 'ok'], 200);
        } else {
            return response()->json(['message' => 'Invalid code'], 400);
        }
    }


    public function delete2FACode(Request $request)
    {
        $user = auth()->user();
        $user->google2fa_secret = null;
        $user->save();
        return response()->json(['message' => 'Authorization deleted'], 200);
    }

    protected function respondWithToken($token): JsonResponse
    {
        return new JsonResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
