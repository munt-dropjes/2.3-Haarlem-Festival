<?php

namespace Models;

class Home{
    private string $pageContent;

    public function getData(): string
    {
        return $this->pageContent;
    }

    public function setData(string $data): void
    {
        $this->pageContent = $data;
    }
}