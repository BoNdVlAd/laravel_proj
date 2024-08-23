<?php

namespace App\Rules;

use App\Models\Order;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PaymentCheckRule implements ValidationRule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $order = request()->order;
        $paymentAmount = request()->amount;

        if ($order->status == 1) {
            $fail('message','the order has already been paid for');
        }
        if ($order->total_price != $paymentAmount) {
            $fail('message','payment amount is incorrect');
        }
    }
}
