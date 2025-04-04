<?php
namespace Models;

use JsonSerializable;

class ShoppingCart implements JsonSerializable
{
	private int $CartID;
	private int $UserID;
	private int $CreatedAt;
	private array $shoppingCartItems;

	public function jsonSerialize(): array
	{
		return [
			'CartID' => $this->CartID,
			'UserID' => $this->UserID,
			'CreatedAt' => $this->CreatedAt,
			'shoppingCartItems' => $this->shoppingCartItems,
		];
	}

	// Getters
	public function getCartID(): int
	{
		return $this->CartID;
	}
	public function getUserID(): int
	{
		return $this->UserID;
	}
	public function getCreatedAt(): int
	{
		return $this->CreatedAt;
	}
	public function getShoppingCartItems(): array
	{
		return $this->shoppingCartItems;
	}

	// Setters
	public function setCartID(int $CartID): void
	{
		$this->CartID = $CartID;
	}
	public function setUserID(int $UserID): void
	{
		$this->UserID = $UserID;
	}
	public function setCreatedAt(int $CreatedAt): void
	{
		$this->CreatedAt = $CreatedAt;
	}
	public function setShoppingCartItems(array $shoppingCartItems): void
	{
		$this->shoppingCartItems = $shoppingCartItems;
	}

	// Additional utilitys
	public function addShoppingCartItem(ShoppingCartItem $shoppingCartItem): void
	{
		$this->shoppingCartItems[] = $shoppingCartItem;
	}
}