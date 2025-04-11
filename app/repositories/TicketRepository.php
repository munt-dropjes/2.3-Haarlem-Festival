<?php

namespace Repositories;

use Models\Event;
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
		$sql = "SELECT 
			T.`TicketID`, T.`OrderID`, T.`EventID`, T.`UserID`, T.`IsFamilyTicket`, T.`Quantity`, T.`QRCode`, T.`IsScanned`, T.`Status`, T.`PurchasedAt`, T.`PaymentStatus`,
			E.`EventID`, E.`Name`, E.`Description`, E.`StartTime`, E.`EndTime`, E.`Location`, E.`Price`,
			IF(S.`FamilyTicketPrice` IS NOT NULL, S.`FamilyTicketPrice`, E.`Price`) AS FamilyTicketPrice,
			E.`TotalTickets`, E.`SoldTickets`, E.`ImageName`, E.`Category`
		FROM
			Tickets AS T
		INNER JOIN
			Events AS E ON T.EventId = E.EventId
		LEFT JOIN
			Stroll AS S ON E.EventID = S.EventID
		WHERE
			UserId = :user_id";
		$stmt = $this->connection->prepare($sql);
		$stmt->bindParam(':user_id', $userId);
		$stmt->execute();
		$tickets = [];
		$tmpTickets = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		foreach ($tmpTickets as $ticketData) {
			$ticket = Ticket::unserialize($ticketData);
			$event = Event::unserialize($ticketData);

			if ($ticket->getIsFamilyTicket()) {
				$event->setPrice($event->getFamilyTicketPrice());
			}

			$ticket->setEvent($event);

			$tickets[] = $ticket;
		}
		return $tickets;
	}

	public function getTicketsByOrderId($orderId)
	{
		$sql = "SELECT * FROM Tickets WHERE OrderId = :order_id";
		$stmt = $this->connection->prepare($sql);
		$stmt->bindParam(':order_id', $orderId);
		$stmt->execute();
		$tickets = [];
		$tmpTickets = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		foreach ($tmpTickets as $ticketData) {
			$ticket = Ticket::unserialize($ticketData);
			$tickets[] = $ticket;
		}
		return $tickets;
	}
}
