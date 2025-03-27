<?php

namespace Repositories;

use Models\Artist;
use Models\Event;
use Exception;
use PDO;

class DanceRepository extends BaseRepository
{
	public function getDanceArtists(): array
	{
		try {
			$sql = "SELECT * FROM Artists WHERE Category = 'Dance'";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();
			$obj = $stmt->fetchAll(PDO::FETCH_CLASS, Artist::class);
			return $obj;
		} catch (Exception $e) {
			throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get all dance artists");
		}
	}

	public function getDanceArtistByName(string $name): Artist
	{
		try {
			$sql = "SELECT * FROM Artists WHERE Name = :name";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute(['name' => $name]);
			$obj = $stmt->fetchObject(Artist::class);
			return $obj;
		} catch (Exception $e) {
			throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get all dance artists");
		}
	}

	public function getAllDanceEvents(): array
	{
		try {
			$sql = "SELECT 
				Events.`EventID`, Events.`Name` AS `EventName`, `Description`, `Date`, `Time`, `Duration`, `Location`, `Price`, `AvailableTickets`, Events.`ImageName` AS EventImage,
				Artists.`ArtistID`, Artists.`Name` AS ArtistName, Artists.`ImageName` AS ArtistImage
			FROM Dance LEFT JOIN Events ON Dance.EventID = Events.EventID LEFT JOIN Artists ON Dance.ArtistID = Artists.ArtistID";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();

			$eventRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$events = [];

			foreach ($eventRows as $eventData) {
				$eventID = $eventData['EventID'];

				if (!isset($events[$eventID])) {
					$event = new Event();
					$event->setEventID($eventID);
					$event->setName($eventData['EventName']);
					$event->setDescription($eventData['Description']);
					$event->setDate($eventData['Date']);
					$event->setTime($eventData['Time']);
					$event->setDuration($eventData['Duration']);
					$event->setLocation($eventData['Location']);
					$event->setPrice($eventData['Price']);
					$event->setAvailableTickets($eventData['AvailableTickets']);
					$event->setImageName($eventData['EventImage']);

					$events[$eventID] = $event;
				}

				// Check if there is an artist associated with this event
				if (!empty($eventData['ArtistID'])) {
					$artist = new Artist();
					$artist->setArtistID($eventData['ArtistID']);
					$artist->setName($eventData['ArtistName']);
					$artist->setImageName($eventData['ArtistImage']);

					$events[$eventID]->addArtist($artist);
				}
			}

			return array_values($events); // Return re-indexed array
		} catch (Exception $e) {
			throw new Exception("Error code: " . $e->getMessage() . " - Something went wrong trying to get all dance events");
		}
	}

	public function getDanceArtistEventsById(int $id): array
	{
		try {
			$sql = "SELECT Events.`EventID`, `Name`, `Description`, `Date`, `Time`, `Location`, `Price`, `AvailableTickets` FROM Dance INNER JOIN Events ON Dance.EventID = Events.EventID WHERE Dance.ArtistID = :id";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute(['id' => $id]);
			$obj = $stmt->fetchAll(PDO::FETCH_CLASS, Event::class);
			return $obj;
		} catch (Exception $e) {
			throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get all dance artist events by id -" . $e->getMessage());
		}
	}

	public function getAllPasses(): array
	{
		try {
			$sql = "SELECT * FROM Events WHERE Name LIKE '%All Access Pass%' AND Category = 'Dance'";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_CLASS, Event::class);
		} catch (Exception $e) {
			throw new Exception("Error code: " . $e->getCode() . " -  Something went wrong trying to get dance all access passes");
		}
	}
}