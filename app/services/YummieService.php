<?php

namespace Services;

use Repositories\YummieRepository;

class YummieService {
    private YummieRepository $repository;

    public function __construct(YummieRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Haalt ALLE restaurants op (standaard weergave).
     */
    public function getAllRestaurants(): array {
        return $this->repository->getAllRestaurants([]);
    }

    /**
     * Haalt restaurants op met de geselecteerde filters.
     */
    public function getFilteredRestaurants(array $filters = []): array {
        $cleanFilters = [];

        if (!empty($filters['cuisine'])) {
            $cleanFilters['cuisine'] = "%" . trim($filters['cuisine']) . "%";
        }
        if (!empty($filters['rating']) && is_numeric($filters['rating'])) {
            $cleanFilters['rating'] = (int)$filters['rating'];
        }
        if (!empty($filters['start_time'])) {
            $cleanFilters['start_time'] = trim($filters['start_time']);
        }
        if (!empty($filters['cost'])) {
            $cleanFilters['cost'] = trim($filters['cost']);
        }

        return $this->repository->getAllRestaurants($cleanFilters);
    }
}
