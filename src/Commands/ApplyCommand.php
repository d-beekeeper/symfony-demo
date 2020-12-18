<?php

namespace App\Commands;

use App\Entity\Item;
use App\Entity\Items;

class ApplyCommand
{
    protected Items $items;
    protected string $code;

    public static function fromJson(array $jsonItems, string $code): self
    {
        $items = [];
        foreach ($jsonItems as $jsonItem) {
            $items[] = new Item($jsonItem['id'], $jsonItem['price']);
        }
        return new self(Items::create($items), $code);
    }

    /**
     * @param Items $items
     * @param string $code
     */
    public function __construct(Items $items, string $code)
    {
        $this->items = $items;
        $this->code = $code;
    }

    public function getItems(): Items
    {
        return $this->items;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
