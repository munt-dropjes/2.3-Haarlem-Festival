<?php

namespace Services;

use Config\StripeConfig;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(StripeConfig::STRIPE_SECRET_KEY);
    }

    public function createCheckoutSession($amount, $currency, $successUrl, $cancelUrl)
    {
        return Session::create([
            'payment_method_types' => ['card', 'ideal'], //the payment options
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => [
                        'name' => 'Haarlem Festival Ticket',
                    ],
                    'unit_amount' => $amount * 100, // amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);
    }
}