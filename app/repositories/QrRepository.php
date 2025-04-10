<?php

namespace Repositories;

use models\Ticket;
use PDO;

class QrRepository extends BaseRepository
{
    public function getAllQrCodes()
    {
        $sql = "SELECT TicketID, EventID, QRCode, IsScanned FROM Tickets";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQrCodeByTicket($ticket)
    {
        $sql = "SELECT * FROM Tickets WHERE TicketID = :ticketID";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':ticketID', $ticket->getTicketID());
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Models\Ticket');
        $fetchedTicket = $stmt->fetch();
        return $fetchedTicket ?: null;
    }

    public function setTicketScanned($ticket)
    {
        $sql = "UPDATE Tickets SET IsScanned = 1 WHERE TicketID = :ticket";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':ticket', $ticket);
        $stmt->execute();
    }
}