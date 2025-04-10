<?php

namespace Services;

use Repositories\ShoppingCartRepository;

class ShoppingCartService
{
	private ShoppingCartRepository $shoppingCartRepository;

	function __construct()
	{
		$this->shoppingCartRepository = new ShoppingCartRepository();
	}

	public function makeOrder(int $userID): int
	{
		return $this->shoppingCartRepository->makeOrder($userID);
	}

	public function addItem(int $userID, int $eventID, int $quantity, bool $isFamilyTicket): int
	{
		if ($quantity < 1) {
			$quantity = 1;
		}

		return $this->shoppingCartRepository->addItem($userID, $eventID, $quantity, $isFamilyTicket);
	}

	public function getUserShoppingCartOrder(int $userID): array
	{
		$shoppingCartItems = $this->shoppingCartRepository->getUserSelectedShoppingCartItems($userID);

		if (!$shoppingCartItems) {
			return [];
		}

		return $shoppingCartItems;
	}

	public function getUserShoppingCartItems(int $userID): array
	{
		$shoppingCartItems = $this->shoppingCartRepository->getUserShoppingCartItems($userID);

		if (!$shoppingCartItems) {
			return [];
		}

		return $shoppingCartItems;
	}

	public function getMultipleEventsById(array $ids): array
	{
		if (empty($ids)) {
			return [];
		}

		$shoppingcartItems = $this->shoppingCartRepository->getMultipleEventsById($ids);

		$tmp = [];

		foreach ($shoppingcartItems as $shoppingcartItem) {
			/** @var \Models\ShoppingCartItem $shoppingcartItem */
			foreach ($ids as $id) {
				if ($shoppingcartItem->getEvent()->getEventID() === $id['eventID'] && isset($id['isFamilyTicket']) && filter_var($id['isFamilyTicket'], FILTER_VALIDATE_BOOL) === true) {
					// $shoppingcartItem->getEvent()->setPrice($shoppingcartItem->getEvent()->getFamilyTicketPrice());
					echo "Family ticket price: " . $shoppingcartItem->getEvent()->getFamilyTicketPrice() . "\n";

					$tmpShoppingcartItem = clone $shoppingcartItem;
					$tmpEvent = clone $shoppingcartItem->getEvent();
					$tmpEvent->setPrice($tmpEvent->getFamilyTicketPrice());
					$tmpShoppingcartItem->setEvent($tmpEvent);
					$tmpShoppingcartItem->setQuantity($id['quantity']);
					$tmpShoppingcartItem->setIsFamilyTicket(true);

					$tmp[] = $tmpShoppingcartItem;
				} else {
					// $shoppingcartItem->getEvent()->setPrice($shoppingcartItem->getEvent()->getPrice());
					echo "Normal ticket price: " . $shoppingcartItem->getEvent()->getPrice() . "\n";

					$tmpShoppingcartItem = clone $shoppingcartItem;
					$tmpEvent = clone $shoppingcartItem->getEvent();
					$tmpShoppingcartItem->setEvent($tmpEvent);
					$tmpShoppingcartItem->setQuantity($id['quantity']);
					$tmpShoppingcartItem->setIsFamilyTicket(false);

					$tmp[] = $tmpShoppingcartItem;
				}
			}
		}

		return $tmp;
	}

	public function updateQuantity(int $userID, int $itemID, int $quantity, $isFamilyTicket): int
	{
		if ($quantity < 1) {
			$quantity = 1;
		}

		return $this->shoppingCartRepository->updateQuantity($userID, $itemID, $quantity, $isFamilyTicket);
	}

	public function removeItem(int $userID, int $itemID, $isFamilyTicket): void
	{
		$this->shoppingCartRepository->removeItem($userID, $itemID, $isFamilyTicket);
	}

	public function selectItem(int $userID, int $itemID, bool $selected, $isFamilyTicket): void
	{
		$this->shoppingCartRepository->selectItem($userID, $itemID, $selected, $isFamilyTicket);
	}

	public function selectAll(int $userID, bool $selected): void
	{
		$this->shoppingCartRepository->selectAll($userID, $selected);
	}

	public function createTickets(int $userID): void
	{
		$this->shoppingCartRepository->createTickets($userID);
	}

	public function clearUserShoppingCartSelectedItems(int $userID): void
	{
		$this->shoppingCartRepository->clearUserShoppingCartSelectedItems($userID);
	}

	public function clearUserShoppingCart(int $userID): void
	{
		$this->shoppingCartRepository->clearShoppingCart($userID);
	}
}