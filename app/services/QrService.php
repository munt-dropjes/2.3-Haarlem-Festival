<?php

namespace Services;

use Repositories\QrRepository;
use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QROutputInterface;

class QrService
{
    private $qrRepository;

    public function __construct()
    {
        $this->qrRepository = new QrRepository();
    }

    public function getAllQrCodes()
    {
        return $this->qrRepository->getAllQrCodes();
    }

    public function setTicketScanned($ticket)
    {
        $this->qrRepository->setTicketScanned($ticket);
    }

    public function createQrCode($url)
    {
        $options = new QROptions;

        $options->version      = 5;
        $options->outputType   = QROutputInterface::MARKUP_HTML;
        $options->cssClass     = 'qrcode';
        $options->moduleValues = [
            // finder
            QRMatrix::M_FINDER_DARK    => '#A71111', // dark (true)
            QRMatrix::M_FINDER_DOT     => '#A71111', // finder dot, dark (true)
            QRMatrix::M_FINDER         => '#FFBFBF', // light (false)
            // alignment
            QRMatrix::M_ALIGNMENT_DARK => '#A70364',
            QRMatrix::M_ALIGNMENT      => '#FFC9C9',
        ];

        $out  = (new QRCode($options))->render($url);

        return $out;
    }

    public function checkTicket($ticket)
    {
        try {
            $ticketData = $this->qrRepository->getQrCodeByTicket($ticket);

            if (!$ticketData) 
                return ['status' => 'incorrect'];

            if ($ticketData['IsScanned'] != 0) 
                return ['status' => 'scanned'];

            if ($ticketData['QRCode'] != $ticket) 
                return ['status' => 'incorrect'];

            $this->setTicketScanned($ticketData['TicketID']);
            return ['status' => 'correct'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}