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

		public function generateTicketPDF($ticket){
			$html = '<!DOCTYPE html>
			<html>
			<head>
				<title>Ticket</title>
			</head>
			<body>
				<h1>Ticket</h1>
				<p>Event: '.$ticket->getEvent().'</p>
				<p>Price: '.$ticket->getPrice().'</p>
				<p>Seat: '.$ticket->getSeat().'</p>
			</body>
			</html>';

			return $this->generatePDF($html);
		}


		public function generateInvoicePDF($invoice){
			$html = '<!DOCTYPE html>
			<html>
			<head>
				<title>Invoice</title>
			</head>
			<body>
				<h1>Invoice</h1>
				<p>Event: '.$invoice->getEvent().'</p>
				<p>Price: '.$invoice->getPrice().'</p>
				<p>Seat: '.$invoice->getSeat().'</p>
			</body>
			</html>';

			return $this->generatePDF($html);
		}
	} 
	?>

?>