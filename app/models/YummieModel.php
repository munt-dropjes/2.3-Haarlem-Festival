<?php

namespace Models;

class YummieModel {
    public ?int $id;
    public string $name;
    public ?int $rating;
    public string $cuisine;
    public string $open_time;
    public ?string $image;

    public function __construct(?int $id, string $name, ?int $rating, string $cuisine, string $open_time, ?string $image) {
        $this->id = $id;
        $this->name = $name;
        $this->rating = $rating ?? 0; // Zet standaard rating op 0 als NULL
        $this->cuisine = $cuisine;
        $this->open_time = $open_time;
        $this->image = $image ?? 'default.jpg'; // Voorkom problemen met lege afbeeldingen
    }

    // Methode om sterren als HTML weer te geven
    public function getStarRating(): string {
        $stars = str_repeat('★', $this->rating);
        $emptyStars = str_repeat('☆', 5 - $this->rating);
        return $stars . $emptyStars;
    }
}
