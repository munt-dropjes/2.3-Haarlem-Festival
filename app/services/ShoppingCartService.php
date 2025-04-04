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

	public function addItem(int $userID, int $eventID, int $quantity): int
	{
		if ($quantity < 1) {
			$quantity = 1;
		}

		return $this->shoppingCartRepository->addItem($userID, $eventID, $quantity);
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

		return $this->shoppingCartRepository->getMultipleEventsById($ids);
	}

	public function updateQuantity(int $userID, int $itemID, int $quantity): int
	{
		if ($quantity < 1) {
			$quantity = 1;
		}

		return $this->shoppingCartRepository->updateQuantity($userID, $itemID, $quantity);
	}

	public function removeItem(int $userID, int $itemID): void
	{
		$this->shoppingCartRepository->removeItem($userID, $itemID);
	}

	public function selectItem(int $userID, int $itemID, bool $selected): void
	{
		$this->shoppingCartRepository->selectItem($userID, $itemID, $selected);
	}

	public function selectAll(int $userID, bool $selected): void
	{
		$this->shoppingCartRepository->selectAll($userID, $selected);
	}
}