<?php

namespace App\Services;

use Exception;
use Illuminate\Http\JsonResponse;
use Stripe;

class PaymentService
{
    /**
     * @param $order
     * @param $content
     * @return JsonResponse
     */
    public function paymentProcess($order, $content): JsonResponse
    {
        try {
            $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));

            $testToken = 'tok_visa';
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $order->status = true;

            $order->save();

            $response = $stripe->charges->create([
                'amount' => $order->total_price,
                'currency' => 'usd',
                'source' => $testToken,
                'description' => $content['description'],
            ]);

            return new JsonResponse([$response], 201);
        } catch (Exception $e) {
            return new JsonResponse(['message'=>'hello'], 500);
        }
    }
}
