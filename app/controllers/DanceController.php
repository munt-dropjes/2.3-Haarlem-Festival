<?php

namespace Controllers;

use Services\DanceService;

class DanceController extends Controller
{
	private $danceService;

	public function __construct()
	{
		$this->danceService = new DanceService();
	}

	public function index()
	{
		$artists = $this->danceService->getDanceArtists();
		$events = $this->danceService->getAllDanceEvents();

		$FridayEvents = array_filter($events, fn($e) => date('l', strtotime($e->getDate())) === 'Friday');
		$SaturdayEvents = array_filter($events, fn($e) => date('l', strtotime($e->getDate())) === 'Saturday');
		$SundayEvents = array_filter($events, fn($e) => date('l', strtotime($e->getDate())) === 'Sunday');

		$AllAccessPass = $this->danceService->getAllPasses();

		$data = [
			'artists' => $artists,
			'events' => $events,
			'FridayEvents' => $FridayEvents,
			'SaturdayEvents' => $SaturdayEvents,
			'SundayEvents' => $SundayEvents,
			'AllAccessPass' => $AllAccessPass,
		];
		$this->view('dance/index', $data);
	}

	public function artist(string $artistName)
	{
		$artist = $this->danceService->getDanceArtistByName($artistName);
		$events = $this->danceService->getDanceArtistEventsById($artist->getArtistID());

		$data = [
			'artist' => $artist,
			'events' => $events
		];
		$this->view('dance/artist', $data);
	}
}