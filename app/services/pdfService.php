<?php

	use Dompdf\Dompdf;

	class PdfService{
		private function generatePDF($html){
		
			$dompdf = new Dompdf();
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();

			return $dompdf->output();
		}

		public function generateTicketPDF($ticket , $qrCode){
			$html = '<!DOCTYPE html>
            <html>
            <head>
                <title>Ticket</title>
            </head>
            <body>
                <h1>Ticket</h1>
                <p>Name: ' . $ticket->getCustomerName() . '</p>
                <p>Event: ' . $ticket->getEventName() . '</p>
                <p>Details:</p>
                <ul>';
                //add the ticket details to the html so the details can just be stored in an array :)
                foreach ($ticket->getEventDetails() as $key => $value) {
                    $html .= '<li>' . htmlspecialchars($key) . ': ' . htmlspecialchars($value) . '</li>';
                }

                $html .= '</ul>
                <img src="' . $qrCode . '" alt="QR Code" />
            </body>
            </html>';
			return $this->generatePDF($html);
		}


		public function generateInvoicePDF($invoice) {
            $html = '<!DOCTYPE html>
            <html>
            <head>
                <title>Invoice</title>
            </head>
            <body>
                <h1>Invoice</h1>
                <p>Invoice Number: ' . $invoice->getInvoiceNumber() . '</p>
                <p>Invoice Date: ' . $invoice->getInvoiceDate() . '</p>
                <p>Client Name: ' . $invoice->getClientName() . '</p>
                <p>Phone: ' . $invoice->getPhoneNumber() . '</p>
                <p>Address: ' . $invoice->getAddress() . '</p>
                <p>Email: ' . $invoice->getEmailAddress() . '</p>
                <p>Subtotal: ' . $invoice->getSubtotal() . '</p>
                <p>VAT (21%): ' . $invoice->getVat21() . '</p>
                <p>VAT (9%): ' . $invoice->getVat9() . '</p>
                <p>Total: ' . $invoice->getTotalAmount() . '</p>
                <p>Payment Date: ' . $invoice->getPaymentDate() . '</p>
            </body>
            </html>';

            return $this->generatePDF($html);
        }


	} 
	?>

?>