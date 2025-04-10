<?php

namespace Repositories;

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

    public function getQrCodeByTicket($ticketID)
    {
        $sql = "SELECT * FROM Tickets WHERE TicketID = :ticketID";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':ticketID', $ticketID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function setTicketScanned($ticket)
    {
        $sql = "UPDATE Tickets SET IsScanned = 1 WHERE TicketID = :ticket";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':ticket', $ticket);
        $stmt->execute();
    }
}