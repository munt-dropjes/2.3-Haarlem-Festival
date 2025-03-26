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

    public function createIntent($amount, $orderId)
    {
        $intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'eur',
            'metadata' => [
                'order_id' => $orderId,
            ],
        ]);

        return $intent->client_secret;
    }

    


    
}