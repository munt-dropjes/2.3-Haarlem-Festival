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
        $this->name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $this->rating = $rating;
        $this->cuisine = array_map(fn($c) => htmlspecialchars($c, ENT_QUOTES, 'UTF-8'), $cuisine);
        $this->seats = $seats;
        $this->open_time = htmlspecialchars($open_time, ENT_QUOTES, 'UTF-8');
        $this->close_time = htmlspecialchars($close_time, ENT_QUOTES, 'UTF-8');
        $this->duration = $duration;
        $this->sessions = $sessions;
        $this->cost = $cost;
        $this->image = htmlspecialchars($image ?: 'default.jpg', ENT_QUOTES, 'UTF-8');
        $this->address = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
        $this->city = htmlspecialchars($city, ENT_QUOTES, 'UTF-8');
        $this->zipcode = htmlspecialchars($zipcode, ENT_QUOTES, 'UTF-8');
        $this->mapLink = htmlspecialchars($mapLink, ENT_QUOTES, 'UTF-8');
        $this->extra_info_menu = htmlspecialchars($extra_info_menu, ENT_QUOTES, 'UTF-8');
        $this->menu_items = $menu_items;

        $this->timeSlots = $this->generateTimeSlots();
    }

    public function generateTimeSlots(): array {
        $timeSlots = [];
        $startTime = DateTime::createFromFormat('H:i', $this->open_time);
        $closeTime = DateTime::createFromFormat('H:i', $this->close_time);

        if (!$startTime || !$closeTime) {
            return [];
        }

        $duration_minutes = $this->duration * 60;
        $interval = new \DateInterval('PT' . $duration_minutes . 'M');

        while ($startTime < $closeTime) {
            $endTime = clone $startTime;
            $endTime->add($interval);

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
