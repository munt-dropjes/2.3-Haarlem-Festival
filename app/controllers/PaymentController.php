<?php

namespace Controllers;

use Models\User;
use Services\PaymentService;
use Services\ShoppingCartService;
use Services\TicketService;
use Services\pdfService;
use Enums\paymentEnum;
use Services\InvoiceService;
use Services\MailerService;
use Services\UserService;
use Services\OrderService;

class PaymentController extends Controller
{
	private $user;
	private $paymentService;
	private $ticketService;
	private $pdfService;
	private $invoiceService;
	private $mailerService;
	private $userService;
	private $orderService;
	private ShoppingCartService $shoppingCart;

	public function __construct()
	{
		$this->paymentService = new PaymentService();
		$this->ticketService = new TicketService();
		$this->pdfService = new pdfService();
		$this->invoiceService = new InvoiceService();
		$this->mailerService = new MailerService();
		$this->userService = new UserService();
		$this->orderService = new OrderService();
		$this->shoppingCart = new ShoppingCartService();

		// Check if user is logged in
		if (isset($_SESSION['user'])) {
			$this->user = $_SESSION['user'];
		}
	}

	public function checkout()
	{
		$data = [];

		if (!isset($_SESSION['user'])) {
			header('Location: /login');
		}

		$orderId = $this->shoppingCart->makeOrder($this->user->getID());
		$totalAmount = 0;
		$shoppingCartItems = $this->shoppingCart->getUserShoppingCartOrder($this->user->getID());

		foreach ($shoppingCartItems as $item) {
			/** @var \Models\ShoppingCartItem $item */
			$totalAmount += $item->getEvent()->getPrice() * $item->getQuantity();
		}
		$totalAmount = $totalAmount * 100; // Convert to cents for Stripe

		$data['ShoppingCartItems'] = $this->shoppingCart->getUserShoppingCartItems($this->user->getID());
		$data['clientSecret'] = $this->createSession($totalAmount, $orderId);
		$data['orderId'] = $orderId;
		$data['user'] = $this->user;

		$data['countries'] = ["Afghanistan", "Åland Islands", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, The Democratic Republic of The", "Cook Islands", "Costa Rica", "Cote D'ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-bissau", "Guyana", "Haiti", "Heard Island and Mcdonald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran, Islamic Republic of", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestinian Territory, Occupied", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and The Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and The South Sandwich Islands", "Spain", "Sri Lanka", "Sudan", "Suriname", "Svalbard and Jan Mayen", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Timor-leste", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Viet Nam", "Virgin Islands, British", "Virgin Islands, U.S.", "Wallis and Futuna", "Western Sahara", "Yemen", "Zambia", "Zimbabwe"];
		$this->view('shopping-cart/checkout', $data);
	}

	//make this a private function later when the front end is ready
	//pass the amount and order id from the front end
	private function createSession($amount, $orderId)
	{
		try {
			$clientSecret = $this->paymentService->createIntent($amount, $orderId);

			return $clientSecret;
		} catch (\Exception $e) {
			http_response_code(500);
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	public function success()
	{
		$this->shoppingCart->createPurchasedTickets($this->user->getID());
		$this->shoppingCart->clearUserShoppingCartSelectedItems(userID: $this->user->getID());
		$this->shoppingCart->clearUserShoppingCart($this->user->getID());

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
		$this->orderService->updateOrderStatus($orderId, paymentEnum::COMPLETED);
		$this->invoiceService->updatePaymentDate($orderId, date('Y-m-d H:i:s'));
		$this->sendEmail($orderId);
	}

	private function handleFailedPayment($paymentIntent)
	{
		$orderId = $paymentIntent->metadata->order_id;
		$this->ticketService->updatePaymentStatus($orderId, paymentEnum::FAILED);
		$this->orderService->updateOrderStatus($orderId, paymentEnum::FAILED);
	}

	private function handleProcessingPayment($paymentIntent)
	{
		$orderId = $paymentIntent->metadata->order_id;
		$this->ticketService->updatePaymentStatus($orderId, paymentEnum::PENDING);
		$this->orderService->updateOrderStatus($orderId, paymentEnum::PENDING);
	}

	private function handleSuccessfulCheckout($session)
	{
		$orderId = $session->metadata->order_id;
		$this->ticketService->updatePaymentStatus($orderId, paymentEnum::PENDING);
		$this->orderService->updateOrderStatus($orderId, paymentEnum::PENDING);
	}

	private function sendEmail($orderId)
	{
		$tempDir = sys_get_temp_dir() . '/pdfs';
		if (!is_dir($tempDir)) {
			mkdir($tempDir, 0777, true);
		}

		$ticketPDFs = [];
		$tickets = $this->ticketService->getTicketsByOrderId($orderId);
		foreach ($tickets as $ticket) {
			$pdfContent = $this->pdfService->generateTicketPDF($ticket);
			$filePath = $tempDir . '/ticket_' . $ticket->getTicketID() . '.pdf';
			file_put_contents($filePath, $pdfContent);
			$ticketPDFs[] = $filePath;
		}

		$invoice = $this->invoiceService->getInvoiceByOrderId($orderId);
		$invoicePdfContent = $this->pdfService->generateInvoicePDF($invoice);
		$invoiceFilePath = $tempDir . '/invoice_' . $invoice->getInvoiceNumber() . '.pdf';
		file_put_contents($invoiceFilePath, $invoicePdfContent);

		$attachments = array_merge($ticketPDFs, [$invoiceFilePath]);

		$user = $this->userService->getUserById($invoice->getUserID());
		$this->mailerService->sendMail(
			$user->getEmail(),
			$user->getName(),
			'Order: ' . $orderId,
			'Your order has been completed',
			$attachments
		);

		foreach ($attachments as $file) {
			unlink($file);
		}
	}
}
