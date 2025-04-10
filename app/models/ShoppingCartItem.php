<?php
namespace Models;

use JsonSerializable;

class ShoppingCartItem implements JsonSerializable
{
	private int $ItemID;
	private int $CartID;
	private int $EventID;
	private int $Quantity;
	private bool $Selected;
	private string $AddedAt;
	private Event $Event;
	private bool $isFamilyTicket = false;

	public function jsonSerialize(): array
	{
		return [
			'ItemID' => $this->ItemID,
			'CartID' => $this->CartID,
			'EventID' => $this->EventID,
			'Quantity' => $this->Quantity,
			'Selected' => $this->Selected,
			'AddedAt' => $this->AddedAt,
			'Event' => $this->Event,
			'FamilyTicketPrice' => $this->Event->getFamilyTicketPrice(),
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
	public function getSelected(): bool
	{
		return $this->Selected;
	}
	public function getAddedAt(): string
	{
		return $this->AddedAt;
	}
	public function getEvent(): Event
	{
		return $this->Event;
	}
	public function getIsFamilyTicket(): bool
	{
		return $this->isFamilyTicket;
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
	public function setSelected(bool $Selected): void
	{
		$this->Selected = $Selected;
	}
	public function setAddedAt(string $AddedAt): void
	{
		$this->AddedAt = $AddedAt;
	}
	public function setEvent(Event $Event): void
	{
		$this->Event = $Event;
	}
	public function setIsFamilyTicket(bool $isFamilyTicket): void
	{
		$this->isFamilyTicket = $isFamilyTicket;
	}

	// Additional utilitys
	public function getSelectedString(): string
	{
		return $this->Selected ? 'true' : 'false';
	}
}