<?php
namespace Models;

use JsonSerializable;

class ShoppingCartItem implements JsonSerializable
{
	private int $ItemID;
	private int $CartID;
	private int $EventID;
	private int $Quantity;
	private string $AddedAt;
	private Event $Event;

	public function jsonSerialize(): array
	{
		return [
			'ItemID' => $this->ItemID,
			'CartID' => $this->CartID,
			'EventID' => $this->EventID,
			'Quantity' => $this->Quantity,
			'AddedAt' => $this->AddedAt,
			'Event' => $this->Event,
		];
	}

	// Getters
	public function getItemID(): int
	{
		return $this->ItemID;
	}
	public function getCartID(): int
	{
		return $this->CartID;
	}
	public function getEventID(): int
	{
		return $this->EventID;
	}
	public function getQuantity(): int
	{
		return $this->Quantity;
	}
	public function getAddedAt(): string
	{
		return $this->AddedAt;
	}
	public function getEvent(): Event
	{
		return $this->Event;
	}

	// Setters
	public function setItemID(int $ItemID): void
	{
		$this->ItemID = $ItemID;
	}
	public function setCartID(int $CartID): void
	{
		$this->CartID = $CartID;
	}
	public function setEventID(int $EventID): void
	{
		$this->EventID = $EventID;
	}
	public function setQuantity(int $Quantity): void
	{
		$this->Quantity = $Quantity;
	}
	public function setAddedAt(string $AddedAt): void
	{
		$this->AddedAt = $AddedAt;
	}
	public function setEvent(Event $Event): void
	{
		$this->Event = $Event;
	}

	// Additional utilitys
}