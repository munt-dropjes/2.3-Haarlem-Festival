<?php

    namespace Services;

	use Dompdf\Dompdf;

	class pdfService{
		private function generatePDF($html){
		
			$dompdf = new Dompdf();
            $options = new \Dompdf\Options();
            $options->setIsRemoteEnabled(true);
            $dompdf->setOptions($options);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();

			return $dompdf->output();
		}

		public function generateTicketPDF($ticket) {
            $html = '<!DOCTYPE html>
            <html>
            <head>
                <title>Ticket</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f4f4f4;
                        color: #333;
                    }
                    .ticket-container {
                        width: 80%;
                        margin: 20px auto;
                        background: #fff;
                        border: 1px solid #ddd;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        padding: 20px;
                    }
                    h1 {
                        text-align: center;
                        color: #444;
                    }
                    p {
                        font-size: 14px;
                        margin: 5px 0;
                    }
                    ul {
                        list-style-type: none;
                        padding: 0;
                        margin: 10px 0;
                    }
                    li {
                        font-size: 14px;
                        margin-bottom: 5px;
                    }
                    .qr-code {
                        text-align: center;
                        margin-top: 20px;
                    }
                    .qr-code img {
                        width: 150px;
                        height: 150px;
                        border: 1px solid #ddd;
                        border-radius: 8px;
                    }
                </style>
            </head>
            <body>
                <div class="ticket-container">
                    <h1>Haarlem Festival Ticket</h1>
                    <p><strong>Event:</strong> ' . htmlspecialchars($ticket->getEventName()) . '</p>
                    <p><strong>Details:</strong></p>
                    <ul>';
                    foreach ($ticket->getEventDetails() as $key => $value) {
                        $html .= '<li><strong>' . htmlspecialchars($key) . ':</strong> ' . htmlspecialchars($value) . '</li>';
                    }
                    $html .= '</ul>
                    <div class="qr-code">
                        <p><strong>Scan this QR Code at the entrance:</strong></p>
                        <img src="' . htmlspecialchars($ticket->getQrCode()) . '" alt="QR Code" />
                    </div>
                </div>
            </body>
            </html>';
            return $this->generatePDF($html);
        }

		public function generateInvoicePDF($invoice) {
            $html = '<!DOCTYPE html>
            <html>
            <head>
                <title>Invoice</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f4f4f4;
                        color: #333;
                    }
                    .invoice-container {
                        width: 80%;
                        margin: 20px auto;
                        background: #fff;
                        border: 1px solid #ddd;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        padding: 20px;
                    }
                    h1 {
                        text-align: center;
                        color: #444;
                        margin-bottom: 20px;
                    }
                    .invoice-header {
                        margin-bottom: 20px;
                    }
                    .invoice-header p {
                        margin: 5px 0;
                        font-size: 14px;
                    }
                    .invoice-details {
                        margin-bottom: 20px;
                    }
                    .invoice-details p {
                        margin: 5px 0;
                        font-size: 14px;
                    }
                    .invoice-summary {
                        border-top: 1px solid #ddd;
                        padding-top: 10px;
                        margin-top: 20px;
                    }
                    .invoice-summary p {
                        margin: 5px 0;
                        font-size: 14px;
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div class="invoice-container">
                    <h1>Invoice</h1>
                    <div class="invoice-header">
                        <p><strong>Invoice Number:</strong> ' . htmlspecialchars($invoice->getInvoiceNumber()) . '</p>
                        <p><strong>Invoice Date:</strong> ' . htmlspecialchars($invoice->getInvoiceDate()) . '</p>
                        <p><strong>Client Name:</strong> ' . htmlspecialchars($invoice->getClientName()) . '</p>
                        <p><strong>Phone:</strong> ' . htmlspecialchars($invoice->getPhoneNumber()) . '</p>
                        <p><strong>Address:</strong> ' . htmlspecialchars($invoice->getAddress()) . '</p>
                        <p><strong>Email:</strong> ' . htmlspecialchars($invoice->getEmailAddress()) . '</p>
                    </div>
                    <div class="invoice-details">
                        <p><strong>Subtotal:</strong> €' . number_format($invoice->getSubtotal(), 2) . '</p>
                        <p><strong>VAT (21%):</strong> €' . number_format($invoice->getVat21(), 2) . '</p>
                        <p><strong>VAT (9%):</strong> €' . number_format($invoice->getVat9(), 2) . '</p>
                    </div>
                    <div class="invoice-summary">
                        <p><strong>Total:</strong> €' . number_format($invoice->getTotalAmount(), 2) . '</p>
                        <p><strong>Payment Date:</strong> ' . htmlspecialchars($invoice->getPaymentDate()) . '</p>
                    </div>
                </div>
            </body>
            </html>';

            return $this->generatePDF($html);
        }


	} 
?>