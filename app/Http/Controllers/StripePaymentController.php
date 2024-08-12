<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreate\OrderPaymentCheck;
use App\Http\Requests\PaymentRequests\PaymentProcessRequest;
use App\Models\Order;
use App\Services\PaymentService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{

    public function __construct(
        private PaymentService $paymentService
    )
    {
    }

    /**
     * @param Request $PaymentRequest
     * @param OrderPaymentCheck $order
     * @return JsonResponse
     */
    public function stripePost(Order $order, PaymentProcessRequest $PaymentRequest): JsonResponse
    {
        $data = $PaymentRequest->getContent();
        $content = json_decode($data, true);

        return $this->paymentService->paymentProcess($order, $content);
    }
}
