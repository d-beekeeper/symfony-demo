<?php

namespace App\Entity;

class Discount
{
    protected Item $item;
    protected int $amount;

    public function __construct(Item $item, int $amount)
    {
        $this->item = $item;
        $this->amount = $amount;
    }

    public function getItem(): Item
    {
        return $this->item;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getPriceWithDiscount(): int
    {
        return $this->item->getPrice() - $this->amount;
    }
}
