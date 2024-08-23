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
     * @OA\Post(
     *     path="/api/payment/{id}",
     *     operationId="paymentForOrder",
     *     tags={"Payment"},
     *     summary="Payment for order",
     *     description="Returns payment data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="number",
     *                 type="integer",
     *                 example=4242424242424242
     *             ),
     *             @OA\Property(
     *                 property="cvc",
     *                 type="integer",
     *                 example=311
     *             ),
     *             @OA\Property(
     *                  property="amount",
     *                  type="integer",
     *                  example=600
     *             ),
     *             @OA\Property(
     *                   property="description",
     *                   type="string",
     *                   example="first payment using"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Charge"
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
     * @param Order $order
     * @param PaymentProcessRequest $paymentRequest
     * @return JsonResponse
     *
     */
    public function stripePost(Order $order, PaymentProcessRequest $paymentRequest): JsonResponse
    {
        $data = $paymentRequest->getContent();
        $content = json_decode($data, true);

        return $this->paymentService->paymentProcess($order, $content);
    }
}
