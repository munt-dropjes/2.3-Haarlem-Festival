<?php

namespace Repositories;

use Models\Order;
use Models\Ticket;

class TicketRepository extends BaseRepository
{
    public function updatePaymentStatus($orderId, $status)
    {
        $sql = "UPDATE payments SET status = :status WHERE order_id = :order_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
    }

    public function getTicketsByUserId($userId)
    {
        $sql = "SELECT * FROM Tickets WHERE UserId = :user_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Ticket::class);
    }

    public function getTicketsByOrderId($orderId)
    {
        $sql = "SELECT * FROM Tickets WHERE OrderId = :order_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Ticket::class);
    }
}
