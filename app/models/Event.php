<?php
namespace Models;

use JsonSerializable;

class Event implements JsonSerializable
{
	private int $EventID;
	private string $Name;
	private string $Description;
	private string $StartTime;
	private string $EndTime;
	private string $Location;
	private float $Price;
	private int $TotalTickets;
	private int $SoldTickets;
	private string $ImageName;
	private string $Category;
	private array $Artists;
	public float $FamilyTicketPrice = 0.0;

	public function __construct(
		int $EventID,
		string $Name,
		string $Description,
		string $StartTime,
		string $EndTime,
		string $Location,
		float $Price,
		int $TotalTickets,
		int $SoldTickets,
		string $ImageName,
		string $Category,
		array $Artists
	) {
		$this->EventID = $EventID;
		$this->Name = $Name;
		$this->Description = $Description;
		$this->StartTime = $StartTime;
		$this->EndTime = $EndTime;
		$this->Location = $Location;
		$this->Price = $Price;
		$this->TotalTickets = $TotalTickets;
		$this->SoldTickets = $SoldTickets;
		$this->ImageName = $ImageName;
		$this->Category = $Category;
		$this->Artists = $Artists;
	}

	public function jsonSerialize(): array
	{
		return [
			'EventID' => $this->EventID,
			'Name' => $this->Name,
			'Description' => $this->Description,
			'StartTime' => $this->StartTime,
			'EndTime' => $this->EndTime,
			'Location' => $this->Location,
			'Price' => $this->Price,
			'TotalTickets' => $this->TotalTickets,
			'AvailableTickets' => $this->getAvailableTickets(),
			'SoldTickets' => $this->getSoldTickets(),
			'ImageName' => $this->ImageName,
			'Category' => $this->Category,
			'Artists' => $this->Artists,
			'FamilyTicketPrice' => $this->FamilyTicketPrice,
		];
	}

	public static function unserialize(array $data): self
	{
		return new self(
			$data['EventID'] ?? 0,
			$data['Name'] ?? '',
			$data['Description'] ?? '',
			$data['StartTime'] ?? '',
			$data['EndTime'] ?? '',
			$data['Location'] ?? '',
			$data['Price'] ?? 0.0,
			$data['TotalTickets'] ?? 0,
			$data['SoldTickets'] ?? 0,
			$data['ImageName'] ?? '',
			$data['Category'] ?? '',
			$data['Artists'] ?? []
		);
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
	public function getStartTime(): string
	{
		return $this->StartTime;
	}
	public function getEndTime(): string
	{
		return $this->EndTime;
	}
	public function getLocation(): string
	{
		return $this->Location;
	}
	public function getPrice(): float
	{
		return round($this->Price, 2);
	}
	public function getTotalTickets(): int
	{
		return $this->TotalTickets;
	}
	public function getSoldTickets(): int
	{
		return $this->SoldTickets;
	}
	public function getAvailableTickets(): int
	{
		$AvailableTickets = $this->TotalTickets - $this->SoldTickets;
		return $AvailableTickets < 0 ? 0 : $AvailableTickets;
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
	public function getFamilyTicketPrice(): float
	{
		return $this->FamilyTicketPrice;
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
	public function setStartTime(string $StartTime): void
	{
		$this->StartTime = $StartTime;
	}
	public function setEndTime(string $EndTime): void
	{
		$this->EndTime = $EndTime;
	}
	public function setLocation(string $Location): void
	{
		$this->Location = $Location;
	}
	public function setPrice(float $Price): void
	{
		$this->Price = $Price;
	}
	public function setTotalTickets(int $TotalTickets): void
	{
		$this->TotalTickets = $TotalTickets;
	}
	public function setSoldTickets(int $SoldTickets): void
	{
		$this->SoldTickets = $SoldTickets;
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
	public function setFamilyTicketPrice(float $FamilyTicketPrice): void
	{
		$this->FamilyTicketPrice = $FamilyTicketPrice;
	}

	// Additional utilitys
	public function getDate(): string
	{
		// Get date from start time
		$date = date('Y-m-d', strtotime($this->StartTime));
		return $date;
	}
	public function getDuration(): int
	{
		// calculate duration in minutes
		$startTime = strtotime($this->StartTime);
		$endTime = strtotime($this->EndTime);
		$duration = ($endTime - $startTime) / 60;
		return $duration;
	}

	public function addArtist(Artist $artist): void
	{
		$this->Artists[] = $artist;
	}
}