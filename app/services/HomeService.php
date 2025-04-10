<?php

namespace Services;

use Models\Home;

class HomeService
{
    private Home $homeModel;

    public function __construct()
    {
        $this->homeModel = new Home();
    }

    public function getContent(): string
    {
        return $this->homeModel->getData();
    }

    public function saveContent(string $data): void
    {
        $this->homeModel->setData($data);
    }
}