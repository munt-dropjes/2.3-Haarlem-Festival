<?php

namespace Models;

use JsonSerializable;

class MenuItemModel implements JsonSerializable
{
    public int $id;
    public int $restaurantId;
    public string $category;
    public string $name;
    public string $description;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'restaurant_id' => $this->restaurantId,
            'category' => $this->category,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}

