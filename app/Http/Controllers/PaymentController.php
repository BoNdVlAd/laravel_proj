<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function __construct(
    )
    {
    }

    /**
     * @param Order $order
     * @return void
     */
    public function createPayment(Order $order): void
    {
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->status = $order->status;
        $payment->delivery = false;
        $payment->save();
    }

    /**
     * @param int $order_id
     * @return void
     */
    public function changePaymentStatus(int $order_id): void
    {
        $payment = Payment::all()->where('order_id', $order_id)->first();

        $payment->status = 1;

        $payment->save();
    }
}
