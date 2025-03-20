<?php
namespace models;

use JsonSerializable;

class Event implements JsonSerializable
{
	private int $EventID;
	private string $Name;
	private string $Description;
	private string $Date;
	private string $Time;
	private int $Duration;
	private string $Location;
	private float $Price;
	private int $AvailableTickets;
	private string $ImageName;
	private string $Category;
	private array $Artists;

	public function jsonSerialize(): array
	{
		return [
			'EventID' => $this->EventID,
			'Name' => $this->Name,
			'Description' => $this->Description,
			'Date' => $this->Date,
			'Time' => $this->Time,
			'Duration' => $this->Duration,
			'Location' => $this->Location,
			'Price' => $this->Price,
			'AvailableTickets' => $this->AvailableTickets,
			'ImageName' => $this->ImageName,
			'Category' => $this->Category,
			'Artists' => $this->Artists
		];
	}

	// Getters
	public function getEventID(): int
	{
		return $this->EventID;
	}
	public function getName(): string
	{
		return $this->Name;
	}
	public function getDescription(): string
	{
		return $this->Description;
	}
	public function getDate(): string
	{
		return $this->Date;
	}
	public function getTime(): string
	{
		return $this->Time;
	}
	public function getDuration(): int
	{
		return $this->Duration;
	}
	public function getLocation(): string
	{
		return $this->Location;
	}
	public function getPrice(): float
	{
		return $this->Price;
	}
	public function getAvailableTickets(): int
	{
		return $this->AvailableTickets;
	}
	public function getImageName(): string
	{
		return $this->ImageName;
	}
	public function getCategory(): string
	{
		return $this->Category;
	}
	public function getArtists(): array
	{
		return $this->Artists;
	}

	// Setters
	public function setEventID(int $EventID): void
	{
		$this->EventID = $EventID;
	}
	public function setName(string $Name): void
	{
		$this->Name = $Name;
	}
	public function setDescription(string $Description): void
	{
		$this->Description = $Description;
	}
	public function setDate(string $Date): void
	{
		$this->Date = $Date;
	}
	public function setTime(string $Time): void
	{
		$this->Time = $Time;
	}
	public function setDuration(int $Duration): void
	{
		$this->Duration = $Duration;
	}
	public function setLocation(string $Location): void
	{
		$this->Location = $Location;
	}
	public function setPrice(float $Price): void
	{
		$this->Price = $Price;
	}
	public function setAvailableTickets(int $AvailableTickets): void
	{
		$this->AvailableTickets = $AvailableTickets;
	}
	public function setImageName(string $ImageName): void
	{
		$this->ImageName = $ImageName;
	}
	public function setCategory(string $Category): void
	{
		$this->Category = $Category;
	}
	public function setArtists(array $Artists): void
	{
		$this->Artists = $Artists;
	}

	// Additional utilitys
	public function addArtist(Artist $artist): void
	{
		$this->Artists[] = $artist;
	}
}