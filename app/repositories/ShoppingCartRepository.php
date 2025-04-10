<?php

namespace Repositories;

use Models\Artist;
use Models\Event;
use Exception;
use Models\ShoppingCartItem;
use PDO;
use PDOException;

class ShoppingCartRepository extends BaseRepository
{
	public function addItem(int $userID, int $eventID, int $quantity, bool $isFamilyTicket): int
	{
		try {
			$this->connection->beginTransaction();

			// Check if the user has an active shopping cart
			$sql = "SELECT CartID FROM ShoppingCart WHERE UserID = :userID";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute([':userID' => $userID]);
			$cart = $stmt->fetch(PDO::FETCH_ASSOC);

			// If no active shopping cart exists, create one
			if (!$cart) {
				$sql = "INSERT INTO ShoppingCart (UserID) VALUES (:userID)";
				$stmt = $this->connection->prepare($sql);
				$stmt->execute([':userID' => $userID]);
				$cartID = $this->connection->lastInsertId();
			} else {
				$cartID = $cart['CartID'];
			}

			// Check if the item already exists in the shopping cart
			$sql = "SELECT
				ItemID, Quantity, isFamilyTicket
			FROM
			 	ShoppingCartItems
			WHERE
				CartID = :cartID AND EventID = :eventID AND isFamilyTicket = :isFamilyTicket";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute([
				':cartID' => $cartID,
				':eventID' => $eventID,
				':isFamilyTicket' => (int) $isFamilyTicket
			]);
			$item = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($item) {
				// If the item exists, update its quantity using the updateQuantity method
				$this->updateQuantity($userID, $item['ItemID'], $item['Quantity'] + $quantity, $isFamilyTicket);
			} else {
				// If the item does not exist, add it to the shopping cart
				$sql = "INSERT INTO ShoppingCartItems (CartID, EventID, Quantity, Selected, isFamilyTicket, AddedAt) 
						VALUES (:cartID, :eventID, :quantity, 0, :isFamilyTicket, NOW())";
				$stmt = $this->connection->prepare($sql);
				$stmt->execute([
					':cartID' => $cartID,
					':eventID' => $eventID,
					':quantity' => $quantity,
					':isFamilyTicket' => (int) $isFamilyTicket
				]);
			}

			$this->connection->commit();

			return $this->connection->lastInsertId();
		} catch (PDOException $e) {
			$this->connection->rollBack();
			throw new Exception("Error code: " . $e->getCode() . " - Something went wrong trying to add the item to the shopping cart.");
		}
	}

	public function getUserShoppingCartItems(int $userID): array
	{
		try {
			$sql = "SELECT
				SC.`CartID`, SC.`UserID`,
				SCI.`ItemID`, SCI.`CartID`, SCI.`Quantity`, SCI.`Selected`, SCI.`isFamilyTicket`, SCI.`AddedAt`,
				E.`EventID`, E.`Name`, E.`StartTime`, E.`EndTime`, E.`Location`, 
				IF(SCI.`isFamilyTicket` = 1 AND S.`FamilyTicketPrice` IS NOT NULL, S.`FamilyTicketPrice`, E.`Price`) AS Price,
				E.`ImageName`, E.`Category`
			FROM
				ShoppingCart AS SC
			INNER JOIN
				ShoppingCartItems AS SCI ON SC.CartID = SCI.CartID
			INNER JOIN
				Events AS E ON SCI.EventID = E.EventID
			LEFT JOIN
				Stroll AS S ON E.EventID = S.EventID
			WHERE
				SC.UserID = :userID
			ORDER BY
				SCI.AddedAt DESC
			";

			$stmt = $this->connection->prepare($sql);
			$stmt->execute([
				':userID' => $userID
			]);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$items = [];
			foreach ($results as $row) {
				$shoppingCartItem = new ShoppingCartItem();
				$shoppingCartItem->setItemID($row['ItemID']);
				$shoppingCartItem->setCartID($row['CartID']);
				$shoppingCartItem->setEventID($row['EventID']);
				$shoppingCartItem->setQuantity($row['Quantity']);
				$shoppingCartItem->setSelected($row['Selected']);
				$shoppingCartItem->setAddedAt($row['AddedAt']);
				$shoppingCartItem->setIsFamilyTicket($row['isFamilyTicket']);

				$event = new Event();
				$event->setEventID($row['EventID']);
				$event->setName($row['Name']);
				$event->setStartTime($row['StartTime']);
				$event->setEndTime($row['EndTime']);
				$event->setLocation($row['Location']);
				$event->setPrice($row['Price']);
				$event->setImageName($row['ImageName']);
				$event->setCategory($row['Category']);

				$shoppingCartItem->setEvent($event);

				$items[] = $shoppingCartItem;
			}

			return $items;
		} catch (Exception $e) {
			throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get all shopping cart items");
		}
	}

	public function getMultipleEventsById(array $ids): array
	{
		try {
			$inQuery = implode(',', array_fill(0, count($ids), '?'));

			$sql = "SELECT
				E.`EventID`, E.`Name`, E.`StartTime`, E.`EndTime`, E.`Location`, E.`Price`, E.`ImageName`, E.`Category`,
				IF(S.`FamilyTicketPrice` IS NOT NULL, S.`FamilyTicketPrice`, E.`Price`) AS FamilyPrice
			FROM
				Events AS E
			LEFT JOIN
				Stroll AS S ON E.EventID = S.EventID
			WHERE
				E.EventID IN ($inQuery)
			";

			$stmt = $this->connection->prepare($sql);
			$stmt->execute(array_column($ids, 'eventID'));
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$cartMap = [];
			foreach ($_SESSION['shoppingCart'] as $item) {
				$cartMap[$item['eventID']] = $item;
			}

			$items = [];
			foreach ($results as $row) {
				$shoppingCartItem = new ShoppingCartItem();
				$shoppingCartItem->setItemID($row['EventID']);
				$shoppingCartItem->setCartID(0);
				$shoppingCartItem->setEventID($row['EventID']);
				if (isset($cartMap[$row['EventID']])) {
					$cartItem = $cartMap[$row['EventID']];
					$shoppingCartItem->setQuantity($cartItem['quantity']);
					$shoppingCartItem->setSelected($cartItem['selected']);
				}

				$event = new Event();
				$event->setEventID($row['EventID']);
				$event->setName($row['Name']);
				$event->setStartTime($row['StartTime']);
				$event->setEndTime($row['EndTime']);
				$event->setLocation($row['Location']);
				$event->setPrice($row['Price']);
				$event->setImageName($row['ImageName']);
				$event->setCategory($row['Category']);
				$event->FamilyTicketPrice = $row['FamilyPrice'];

				$shoppingCartItem->setEvent($event);

				$items[] = $shoppingCartItem;
			}

			return $items;
		} catch (Exception $e) {
			throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get all shopping cart items");
		}
	}

	public function updateQuantity(int $userID, int $itemID, int $quantity, $isFamilyTicket): int
	{
		try {
			// Check if the item belongs to the given user
			$sql = "UPDATE ShoppingCartItems 
                SET Quantity = :quantity 
                WHERE ItemID = :itemID 
                AND CartID IN (SELECT CartID FROM ShoppingCart WHERE UserID = :userID)
				AND isFamilyTicket = :isFamilyTicket";

			$stmt = $this->connection->prepare($sql);
			$stmt->execute([
				':quantity' => $quantity,
				':itemID' => $itemID,
				':userID' => $userID,
				':isFamilyTicket' => (int) $isFamilyTicket
			]);

			if ($stmt->rowCount() === 0) {
				throw new Exception("No items were updated.");
			}

			return $quantity;
		} catch (PDOException $e) {
			throw new Exception("Error code: " . $e->getCode() . " - Something went wrong trying to update the quantity.");
		}
	}

	public function removeItem(int $userID, int $itemID, $isFamilyTicket): void
	{
		try {
			// Check if the item belongs to the given user
			$sql = "DELETE FROM ShoppingCartItems 
				WHERE ItemID = :itemID 
				AND CartID IN (SELECT CartID FROM ShoppingCart WHERE UserID = :userID)
				AND isFamilyTicket = :isFamilyTicket";

			$stmt = $this->connection->prepare($sql);
			$stmt->execute([
				':itemID' => $itemID,
				':userID' => $userID,
				':isFamilyTicket' => (int) $isFamilyTicket
			]);

			if ($stmt->rowCount() === 0) {
				throw new Exception("No items were removed.");
			}
		} catch (PDOException $e) {
			throw new Exception("Error code: " . $e->getCode() . " - Something went wrong trying to remove the item.");
		}
	}

	public function selectItem(int $userID, int $itemID, bool $selected, $isFamilyTicket): void
	{
		try {
			// Check if the item belongs to the given user
			$sql = "UPDATE ShoppingCartItems 
				SET Selected = :selected 
				WHERE ItemID = :itemID 
				AND CartID IN (SELECT CartID FROM ShoppingCart WHERE UserID = :userID)
				AND isFamilyTicket = :isFamilyTicket";

			$stmt = $this->connection->prepare($sql);
			$stmt->execute([
				':selected' => (int) $selected,
				':itemID' => $itemID,
				':userID' => $userID,
				':isFamilyTicket' => (int) $isFamilyTicket
			]);

			if ($stmt->rowCount() === 0) {
				throw new Exception("No items were updated.");
			}
		} catch (PDOException $e) {
			throw new Exception("Error code: " . $e->getCode() . " - Something went wrong trying to select the item.");
		}
	}

	public function selectAll(int $userID, bool $selected): void
	{
		try {
			// Check if the item belongs to the given user
			$sql = "UPDATE ShoppingCartItems 
				SET Selected = :selected 
				WHERE CartID IN (SELECT CartID FROM ShoppingCart WHERE UserID = :userID)";

			$stmt = $this->connection->prepare($sql);
			$stmt->execute([
				':selected' => (int) $selected,
				':userID' => $userID
			]);

			if ($stmt->rowCount() === 0) {
				throw new Exception("No items were updated.");
			}
		} catch (PDOException $e) {
			throw new Exception("Error code: " . $e->getCode() . " - Something went wrong trying to select the item.");
		}
	}
}