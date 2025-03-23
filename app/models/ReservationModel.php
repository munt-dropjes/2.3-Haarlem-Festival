<?php

namespace Models;

class ReservationModel{
    public int $id;
    public int $restaurant_id;
    public int $adults;
    public int $children;
    public string $day;
    public string $start_time;
    public float $total_price;
    public string $extra_information;
    public string $created_at;
}


