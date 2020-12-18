<?php

namespace App\Entity;

class Item
{
    protected int $id;
    protected int $price;

    public function __construct(int $id, int $price)
    {
        $this->id = $id;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
