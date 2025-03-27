<?php

namespace Services;

use Repositories\YummieRepository;
use Models\YummieModel;

class YummieService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new YummieRepository();
    }

    /**
     * Haalt ALLE restaurants op (standaard weergave).
     */
    public function getAllRestaurants(): array
    {
        return $this->repository->getAllRestaurants([]);
    }

    public function getRestaurantById(int $id): ?YummieModel
    {
        return $this->repository->getRestaurantById($id);
    }

    public function getUniqueDurations(): array
    {
        return $this->repository->getUniqueDurations();
    }

    public function getUniqueOpenTimes(): array
    {
        return $this->repository->getUniqueOpenTimes();
    }

    public function getUniqueCuisines(): array
    {
        return $this->repository->getUniqueCuisines();
    }

    public function getUniqueCosts(): array
    {
        $costs = $this->repository->getUniqueCosts();

        $formattedCosts = [];
        foreach ($costs as $cost) {
            if ($cost == 35) {
                $formattedCosts[$cost] = "€"; // Goedkoop
            } elseif ($cost == 45) {
                $formattedCosts[$cost] = "€€"; // Gemiddeld
            }
        }
        return $formattedCosts;
    }

    public function getUniqueRatings(): array
    {
        return $this->repository->getUniqueRatings();
    }

    /**
     * Haalt restaurants op met de geselecteerde filters.
     */
    public function getFilteredRestaurants(array $filters = []): array
    {
        $cleanFilters = [];

        if (!empty($filters['duration']) && is_numeric($filters['duration'])) {
            $cleanFilters['duration'] = (float) $filters['duration'];
        }
        if (!empty($filters['cuisine'])) {
            $cleanFilters['cuisine'] = trim($filters['cuisine']);
        }
        if (!empty($filters['rating']) && is_numeric($filters['rating'])) {
            $cleanFilters['rating'] = (int) $filters['rating'];
        }
        if (!empty($filters['open_time'])) {
            $cleanFilters['open_time'] = trim($filters['open_time']);
        }
        if (!empty($filters['cost'])) {
            $cleanFilters['cost'] = (float) $filters['cost'];
        }

        return $this->repository->getAllRestaurants($cleanFilters);
    }

    public function getImagesByRestaurantId(int $restaurantId): array
    {
        return $this->repository->getImagesByRestaurantId($restaurantId);
    }
}
