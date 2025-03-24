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

	public function getUserShoppingCartItems(int $userID): array
	{
		$shoppingCartItems = $this->shoppingCartRepository->getUserShoppingCartItems($userID);

		if (!$shoppingCartItems) {
			return [];
		}

		return $shoppingCartItems;
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
}