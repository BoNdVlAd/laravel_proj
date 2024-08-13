<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequests\PaymentProcessRequest;
use App\Models\Order;
use App\Services\PaymentService;
use Symfony\Component\HttpFoundation\JsonResponse;

class StripePaymentController extends Controller
{

    public function __construct(
        private PaymentService $paymentService
    )
    {
    }

    /**
     * @param Order $order
     * @param PaymentProcessRequest $paymentRequest
     * @return JsonResponse
     */
    public function stripePost(Order $order, PaymentProcessRequest $paymentRequest): JsonResponse
    {
        $data = $paymentRequest->getContent();
        $content = json_decode($data, true);

        return $this->paymentService->paymentProcess($order, $content);
    }
}
