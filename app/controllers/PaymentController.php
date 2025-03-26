<?php

namespace Controllers;

use Services\PaymentService;

class PaymentController extends Controller
{
    private $paymentService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
    }

    public function createSession()
    {
        $amount = 1000; 
        $orderId = 1;
    
        try {
            $clientSecret = $this->paymentService->createIntent($amount, $orderId);

            $this->view('payment/index', ['clientSecret' => $clientSecret]);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function success()
    {
        $this->view('payment/complete');
    }

    public function cancel()
    {
        $this->view('payment/cancel');
    }

    public function webhook()
    {
        $payload = @file_get_contents('php://input');
        $sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $endpointSecret = 'whsec_0fdd77140fca310bb9f6faddd183d471bdeedeeb9157163087c220079fe6ed10';

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );

            switch ($event->type) {
                case 'checkout.session.completed':
                    $session = $event->data->object; 
                    $this->handleSuccessfulPayment($session);
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object; 
                    $this->handleFailedPayment($paymentIntent);
                    break;
                
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object; 
                    $this->handleSuccessfulPayment($paymentIntent);
                    break;

                case 'payment_intent.processing':
                    $paymentIntent = $event->data->object; 
                    $this->handleProcessingPayment($paymentIntent);
                    break;
                default:
                    http_response_code(200);
                    exit();
            }

            http_response_code(200);
        } catch (\UnexpectedValueException $e) {
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            http_response_code(400);
            exit();
        }
    }

    private function handleSuccessfulPayment($session)
    {
        // Update your database to mark the payment as successful
        $orderId = $session->metadata->order_id; // Example: Retrieve custom metadata
        // Update the order status in your database
    }

    private function handleFailedPayment($paymentIntent)
    {
        // Handle failed payment (e.g., notify the user, log the error)
    }

    private function handleprocessingPayment($paymentIntent)
    {
        // Handle failed payment (e.g., notify the user, log the error)
    }
}