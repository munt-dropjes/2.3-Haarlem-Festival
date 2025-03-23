<?php

namespace Models;

use DateTime;

class YummieModel {
    public int $id;
    public string $name;
    public int $rating;
    public int $seats;
    public array $cuisine;
    public string $open_time;
    public string $close_time;
    public float $duration;
    public int $sessions;
    public int $cost;
    public string $image;
    public array $timeSlots = [];
    public array $availableDays = ["Thursday", "Friday", "Saturday", "Sunday"];
    public string $address;
    public string $city;
    public string $zipcode;
    public string $mapLink;
    public string $extra_info_menu;
    public array $menu_items = [];

    public function __construct(
        int $id,
        string $name,
        int $rating,
        array $cuisine,
        int $seats,
        string $open_time,
        string $close_time,
        float $duration,
        int $sessions,
        int $cost,
        string $image,
        string $address,
        string $city,
        string $zipcode,
        string $mapLink,
        string $extra_info_menu,
        array $menu_items
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->rating = $rating;
        $this->cuisine = $cuisine;
        $this->seats = $seats;
        $this->open_time = $open_time;
        $this->close_time = $close_time;
        $this->duration = $duration;
        $this->sessions = $sessions;
        $this->cost = $cost;
        $this->image = $image ?: 'default.jpg';
        $this->address = $address;
        $this->city = $city;
        $this->zipcode = $zipcode;
        $this->mapLink = $mapLink;
        $this->extra_info_menu = $extra_info_menu;
        $this->menu_items = $menu_items;
        

        // Genereer de tijdsblokken op basis van open_time & duration
        $this->timeSlots = $this->generateTimeSlots();
    }

    public function generateTimeSlots(): array {
        $timeSlots = [];
        
        // ✅ Zet open_time en close_time om naar DateTime objecten
        $startTime = DateTime::createFromFormat('H:i', $this->open_time);
        $closeTime = DateTime::createFromFormat('H:i', $this->close_time);
        
        if (!$startTime || !$closeTime) {
            return []; // Als de tijden niet correct zijn, retourneer een lege array.
        }
    
        // ✅ Duration staat in uren in de database, dus omzetten naar minuten
        $duration_minutes = $this->duration * 60; // 3 uur → 180 minuten
    
        // ✅ Maak een tijdsinterval van de juiste duur
        $interval = new \DateInterval('PT' . $duration_minutes . 'M'); // 'M' staat voor minuten
    
        while ($startTime < $closeTime) {
            $endTime = clone $startTime;
            $endTime->add($interval);
    
            // Zorg ervoor dat we niet buiten de sluitingstijd gaan
            if ($endTime > $closeTime) {
                break;
            }
    
            $timeSlots[] = [
                'start' => $startTime->format('H:i'),
                'end' => $endTime->format('H:i')
            ];
    
            $startTime->add($interval);
        }
    
        return $timeSlots;
    }
    

    public function getStarRating(): string {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function getReservationDescription(): string {
        return <<<TEXT
        Reserve Your Table at {$this->name}.

        Reservations are required to secure your spot during the Haarlem Festival. When booking through the Haarlem Festival website, a reservation fee of €10,- per person will be charged. This fee will be deducted from your final bill when you visit our restaurant.

        Do you have special requests? Let us know when making your reservation! Whether it’s dietary preferences, allergies, or requirements like wheelchair accessibility, our team is here to ensure your experience is as enjoyable as possible.

        By clicking the "Submit Reservation" button, these products will be added to your personal wishlist. From the wishlist, you can proceed to payment.

        We look forward to welcoming you to {$this->name}!
        TEXT;
    }
    public function getCuisines(): string {
        return implode(", ", $this->cuisine);
    }
    
}
