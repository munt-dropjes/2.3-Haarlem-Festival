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
        $currency = 'eur';
        $successUrl = 'http://localhost/success'; 
        $cancelUrl = 'http://localhost/cancel';

        $session = $this->paymentService->createCheckoutSession($amount, $currency, $successUrl, $cancelUrl);

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
}