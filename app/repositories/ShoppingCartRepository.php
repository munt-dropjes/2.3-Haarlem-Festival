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
	public function getUserShoppingCartItems(int $userID): array
	{
		try {
			$sql = "SELECT
				SC.`CartID`, SC.`UserID`,
				SCI.`ItemID`, SCI.`CartID`, SCI.`Quantity`, SCI.`Selected`, SCI.`AddedAt`,
				E.`EventID`, E.`Name`, E.`StartTime`, E.`EndTime`, E.`Location`, E.`Price`, E.`ImageName`, E.`Category`
			FROM
				ShoppingCart AS SC
			INNER JOIN
				ShoppingCartItems AS SCI
			ON
				SC.CartID = SCI.CartID
			INNER JOIN
				Events AS E
			ON
				SCI.EventID = E.EventID
			WHERE
				SC.UserID = :userID
			ORDER BY SCI.AddedAt DESC
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
				E.`EventID`, E.`Name`, E.`StartTime`, E.`EndTime`, E.`Location`, E.`Price`, E.`ImageName`, E.`Category`
			FROM
				Events AS E
			WHERE
				EventID IN ($inQuery)
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

				$shoppingCartItem->setEvent($event);

				$items[] = $shoppingCartItem;
			}

			return $items;
		} catch (Exception $e) {
			throw new Exception("Error code: " . $e->getMessage() . " -  Something went wrong trying to get all shopping cart items");
		}
	}

	public function updateQuantity(int $userID, int $itemID, int $quantity): int
	{
		try {
			// Check if the item belongs to the given user
			$sql = "UPDATE ShoppingCartItems 
                SET Quantity = :quantity 
                WHERE ItemID = :itemID 
                AND CartID IN (SELECT CartID FROM ShoppingCart WHERE UserID = :userID)";

			$stmt = $this->connection->prepare($sql);
			$stmt->execute([
				':quantity' => $quantity,
				':itemID' => $itemID,
				':userID' => $userID
			]);

			if ($stmt->rowCount() === 0) {
				throw new Exception("No items were updated.");
			}

			return $quantity;
		} catch (PDOException $e) {
			throw new Exception("Error code: " . $e->getCode() . " - Something went wrong trying to update the quantity.");
		}
	}

	public function removeItem(int $userID, int $itemID): void
	{
		try {
			// Check if the item belongs to the given user
			$sql = "DELETE FROM ShoppingCartItems 
				WHERE ItemID = :itemID 
				AND CartID IN (SELECT CartID FROM ShoppingCart WHERE UserID = :userID)";

			$stmt = $this->connection->prepare($sql);
			$stmt->execute([
				':itemID' => $itemID,
				':userID' => $userID
			]);

			if ($stmt->rowCount() === 0) {
				throw new Exception("No items were removed.");
			}
		} catch (PDOException $e) {
			throw new Exception("Error code: " . $e->getCode() . " - Something went wrong trying to remove the item.");
		}
	}

	public function selectItem(int $userID, int $itemID, bool $selected): void
	{
		try {
			// Check if the item belongs to the given user
			$sql = "UPDATE ShoppingCartItems 
				SET Selected = :selected 
				WHERE ItemID = :itemID 
				AND CartID IN (SELECT CartID FROM ShoppingCart WHERE UserID = :userID)";

			$stmt = $this->connection->prepare($sql);
			$stmt->execute([
				':selected' => (int) $selected,
				':itemID' => $itemID,
				':userID' => $userID
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