<?php

namespace Services;

use Repositories\QrRepository;

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

    public function scanQrTicket($ticket)
    {
        $this->qrRepository->scanQrTicket($ticket);
    }
}