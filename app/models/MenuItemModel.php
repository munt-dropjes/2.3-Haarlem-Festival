<?php

namespace Models;

class MenuItemModel 
{
    public int $id;
    public int $restaurantId;
    public string $category;
    public string $name;
    public string $description;

    public function __construct(
        int $id,
        int $restaurantId,
        string $category,
        string $name,
        string $description
    ) {
        $this->id = $id;
        $this->restaurantId = $restaurantId;
        $this->category = htmlspecialchars($category, ENT_QUOTES, 'UTF-8');
        $this->name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $this->description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    }
}
