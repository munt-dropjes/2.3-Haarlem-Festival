<?php

namespace Repositories;

use Models\Order;

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
}
