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

    public function index()
    {
        $this->view('payment/index');
    }

    public function createSession()
    {
        $amount = $_POST['amount']; 
        $orderId = $_POST['order_id'];
        $currency = 'eur';
        $successUrl = 'http://localhost/success'; 
        $cancelUrl = 'http://localhost/cancel';

        $session = $this->paymentService->createCheckoutSession($amount, $currency, $successUrl, $cancelUrl, $orderId);

        header('Content-Type: application/json');
        echo json_encode(['id' => $session->id]);
    }

    public function success()
    {
        $this->view('payment/success');
    }

    public function cancel()
    {
        $this->view('payment/cancel');
    }

    public function webhook()
    {
        // Retrieve the raw body from the request
        $payload = @file_get_contents('php://input');
        $sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $endpointSecret = 'your_webhook_secret_here'; // Replace with your Stripe webhook secret

        try {
            // Verify the webhook signature
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );

            // Handle the event
            switch ($event->type) {
                case 'checkout.session.completed':
                    $session = $event->data->object; // Contains the session data
                    $this->handleSuccessfulPayment($session);
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object; // Contains the payment intent data
                    $this->handleFailedPayment($paymentIntent);
                    break;
                
                
                // Add more cases for other event types if needed
                default:
                    http_response_code(200);
                    exit();
            }

            http_response_code(200); // Acknowledge receipt of the event
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
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
}