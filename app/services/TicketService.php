<?php

namespace Services;

use Repositories\TicketRepository;

class TicketService
{
    private $ticketRepository;
    public function __construct()
    {
        $this->ticketRepository = new TicketRepository();
    }

    public function updatePaymentStatus($orderId, $status)
    {
        $this->ticketRepository->updatePaymentStatus($orderId, $status);
    }

    public function getTicketsByUserId($userId)
    {
        return $this->ticketRepository->getTicketsByUserId($userId);
    }
}
