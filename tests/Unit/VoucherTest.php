<?php

namespace App\Tests\Unit;

use App\Entity\Voucher;
use PHPUnit\Framework\TestCase;

class VoucherTest extends TestCase
{
    public function testGenerate()
    {
        $voucher = Voucher::generate(10);
        self::assertNotEmpty($voucher->getCode());
        self::assertTrue(strlen($voucher->getCode()) === 7);
        self::assertSame(10, $voucher->getDiscount());
    }
}
