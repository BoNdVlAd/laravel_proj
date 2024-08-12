<?php

namespace App\Http\Requests\OrderCreate;

use App\Http\Requests\BaseRequest;
use App\Models\Order;
use Illuminate\Validation\Validator;

class OrderPaymentCheck extends Order
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $order = Order::find($this->route('order'));
            if ($order->status == "1") {
                $validator->errors()->add('status', 'The order has already been paid for.');
            }
        });
    }
}

