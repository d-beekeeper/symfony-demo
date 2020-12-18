<?php

namespace App\Tests\Unit;

use App\Entity\Item;
use App\Entity\Items;
use PHPUnit\Framework\TestCase;

class ItemsTest extends TestCase
{
    public function testDiscount()
    {
        $item1 = new Item(1, 400);
        $item2 = new Item(2, 600);
        $items = Items::create([$item1, $item2]);
        $discounts = $items->calculateDiscounts(100);

        $discount1 = $discounts[0];
        self::assertSame(40, $discount1->getAmount());
        self::assertSame(360, $discount1->getPriceWithDiscount());

        $discount2 = $discounts[1];
        self::assertSame(60, $discount2->getAmount());
        self::assertSame(540, $discount2->getPriceWithDiscount());
    }
}
