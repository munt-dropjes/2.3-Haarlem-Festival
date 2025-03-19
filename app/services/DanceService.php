<?php

namespace Services;

use Config\Spotify;
use Exception;
use models\Artist;
use Repositories\DanceRepository;

class DanceService
{
	private $danceRepository;

	public function __construct()
	{
		$this->danceRepository = new DanceRepository();
	}

	public function getDanceArtists(): array
	{
		return $this->danceRepository->getDanceArtists();
	}

	public function getDanceArtistByName(string $name): Artist
	{
		return $this->danceRepository->getDanceArtistByName($name);
	}

	public function getAllDanceEvents(): array
	{
		return $this->danceRepository->getAllDanceEvents();
	}

	public function getDanceArtistEventsById(int $id): array
	{
		return $this->danceRepository->getDanceArtistEventsById($id);
	}

	public function getAllPasses(): array
	{
		return $this->danceRepository->getAllPasses();
	}
}