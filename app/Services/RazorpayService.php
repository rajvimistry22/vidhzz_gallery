<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Config;
use Razorpay\Api\Api;
use Throwable;

class RazorpayService
{
    public function configured(): bool
    {
        return filled(Config::get('services.razorpay.key')) && filled(Config::get('services.razorpay.secret'));
    }

    public function createOrder(Order $order): ?array
    {
        if (! $this->configured()) {
            return null;
        }

        $api = new Api(
            Config::get('services.razorpay.key'),
            Config::get('services.razorpay.secret')
        );

        $razorpayOrder = $api->order->create([
            'receipt' => $order->order_number,
            'amount' => (int) round($order->total * 100),
            'currency' => 'INR',
            'payment_capture' => 1,
        ]);

        $order->payment()->updateOrCreate(
            ['order_id' => $order->id],
            [
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $order->total,
                'currency' => 'INR',
                'status' => 'pending',
            ]
        );

        return $razorpayOrder->toArray();
    }

    public function verifySignature(array $attributes): bool
    {
        if (! $this->configured()) {
            return false;
        }

        try {
            $api = new Api(
                Config::get('services.razorpay.key'),
                Config::get('services.razorpay.secret')
            );

            $api->utility->verifyPaymentSignature($attributes);

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    public function markPaid(Payment $payment, array $payload): void
    {
        $payment->update([
            'razorpay_payment_id' => $payload['razorpay_payment_id'] ?? $payment->razorpay_payment_id,
            'razorpay_signature' => $payload['razorpay_signature'] ?? $payment->razorpay_signature,
            'status' => 'paid',
            'method' => $payload['method'] ?? $payment->method,
            'raw_response' => $payload,
            'paid_at' => now(),
        ]);

        $payment->order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);
    }

    public function markFailed(Payment $payment, array $payload = []): void
    {
        $payment->update([
            'status' => 'failed',
            'raw_response' => $payload,
        ]);

        $payment->order->update([
            'payment_status' => 'failed',
        ]);
    }
}
