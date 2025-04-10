<?php

namespace Services;

use Models\Home;
use Repositories\HomeRepository;

class HomeService
{
    private HomeRepository $homeRepository;

    public function __construct()
    {
        $this->homeRepository = new HomeRepository();
    }

    public function getContent(): Home
    {
        return $this->homeRepository->getContent();
    }

    public function saveContent(string $data): void
    {
        $this->homeRepository->saveContent($data);
    }
}