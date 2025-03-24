<?php

	use Dompdf\Dompdf;

	class PdfService{
		public function generatePdf($html){
		
			$dompdf = new Dompdf();
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();

			return $dompdf->output();
		}
	} 
	?>

?>