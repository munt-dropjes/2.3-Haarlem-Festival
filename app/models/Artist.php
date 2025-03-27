<?php
namespace models;

use JsonSerializable;

class Artist implements JsonSerializable
{
	private int $ArtistID;
	private string $Name;
	private string $About;
	private string $KnownFor;
	private string $Song1Link;
	private string $Song2Link;
	private string $Song3Link;
	private string $ImageName;
	private string $Category;
	private string $BannerImage;
	private array $Events;

	public function jsonSerialize(): array
	{
		return [
			'ArtistID' => $this->ArtistID,
			'Name' => $this->Name,
			'About' => $this->About,
			'KnownFor' => $this->KnownFor,
			'Song1Link' => $this->Song1Link,
			'Song2Link' => $this->Song2Link,
			'Song3Link' => $this->Song3Link,
			'ImageName' => $this->ImageName,
			'Category' => $this->Category,
			'BannerImage' => $this->BannerImage,
			'Events' => $this->Events
		];
	}

	// Getters
	public function getArtistID(): int
	{
		return $this->ArtistID;
	}
	public function getName(): string
	{
		return $this->Name;
	}
	public function getAbout(): string
	{
		return $this->About;
	}
	public function getKnownFor(): string
	{
		return $this->KnownFor;
	}
	public function getSong1Link(): string
	{
		return $this->Song1Link;
	}
	public function getSong2Link(): string
	{
		return $this->Song2Link;
	}
	public function getSong3Link(): string
	{
		return $this->Song3Link;
	}
	public function getImageName(): string
	{
		return $this->ImageName;
	}
	public function getCategory(): string
	{
		return $this->Category;
	}
	public function getBannerImage(): string
	{
		return $this->BannerImage;
	}
	public function getEvents(): array
	{
		return $this->Events;
	}

	// Setters
	public function setArtistID(int $ArtistID): void
	{
		$this->ArtistID = $ArtistID;
	}
	public function setName(string $Name): void
	{
		$this->Name = $Name;
	}
	public function setAbout(string $About): void
	{
		$this->About = $About;
	}
	public function setKnownFor(string $KnownFor): void
	{
		$this->KnownFor = $KnownFor;
	}
	public function setSong1Link(string $Song1Link): void
	{
		$this->Song1Link = $Song1Link;
	}
	public function setSong2Link(string $Song2Link): void
	{
		$this->Song2Link = $Song2Link;
	}
	public function setSong3Link(string $Song3Link): void
	{
		$this->Song3Link = $Song3Link;
	}
	public function setImageName(string $ImageName): void
	{
		$this->ImageName = $ImageName;
	}
	public function setCategory(string $Category): void
	{
		$this->Category = $Category;
	}
	public function setBannerImage(string $BannerImage): void
	{
		$this->BannerImage = $BannerImage;
	}
	public function setEvents(array $Events): void
	{
		$this->Events = $Events;
	}

	// Additional utilitys
	public function addEvent(Event $event): void
	{
		$this->Events[] = $event;
	}
}