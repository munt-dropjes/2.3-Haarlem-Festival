<?php

namespace Controllers;

use Services\PaymentService;
use Services\TicketService;
use Services\pdfService;
use Enums\paymentEnum;

class PaymentController extends Controller
{
    private $paymentService;
    private $ticketService;
    private $pdfService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
        $this->ticketService = new TicketService();
        $this->pdfService = new pdfService();
    }


    //make this a private function later when the front end is ready
    //pass the amount and order id from the front end
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
                case 'payment_intent.created':
                    $session = $event->data->object;
                    $this->handleSuccessfulCheckout($session);
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    $this->handleFailedPayment($paymentIntent);
                    break;

                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    $this->handleSuccessfulPayment($paymentIntent);
                    break;

                case 'payment_intent.requires_action':
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

    private function handleSuccessfulPayment($paymentIntent)
    {
        $orderId = $paymentIntent->metadata->order_id;
        $this->ticketService->updatePaymentStatus($orderId, paymentEnum::COMPLETED);
    }

    private function handleFailedPayment($paymentIntent)
    {
        $orderId = $paymentIntent->metadata->order_id;
        $this->ticketService->updatePaymentStatus($orderId, paymentEnum::FAILED);
    }

    private function handleProcessingPayment($paymentIntent)
    {
        $orderId = $paymentIntent->metadata->order_id;
        $this->ticketService->updatePaymentStatus($orderId, paymentEnum::PENDING);
    }

    private function handleSuccessfulCheckout($session)
    {
        $orderId = $session->metadata->order_id;
        $this->ticketService->updatePaymentStatus($orderId, paymentEnum::PENDING);
    }

}
