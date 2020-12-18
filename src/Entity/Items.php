<?php

namespace App\Entity;

class Items
{
    /**
     * @var Item[]
     */
    protected array $items = [];
    protected int $totalPrice;

    /**
     * @param Item[] $items
     */
    public static function create(array $items)
    {
        return new self($items, self::getTotalPrice($items));
    }

    /**
     * @param Item[] $items
     * @param int $totalPrice
     */
    public function __construct(array $items, int $totalPrice)
    {
        $this->items = $items;
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param int $totalDiscount
     * @return Discount[]
     */
    public function calculateDiscounts(int $totalDiscount): array
    {
        $discounts = [];
        $discountLeftover = $totalDiscount;
        foreach ($this->items as $item) {
            $weight = $item->getPrice() / $this->totalPrice;
            $itemDiscount = round($totalDiscount * $weight);
            if ($discountLeftover - $itemDiscount < 0) {
                $discounts[] = new Discount($item, $discountLeftover);
            } else {
                $discounts[] = new Discount($item, $itemDiscount);
            }
            $discountLeftover -= $itemDiscount;
        }
        return $discounts;
    }

    /**
     * @param Item[] $items
     * @return int
     */
    protected static function getTotalPrice(array $items): int
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item->getPrice();
        }
        return $total;
    }
}
