<?php

namespace App\Commands;

class GenerateVoucherCommand
{
    protected int $discount;

    public static function fromJson(array $json): self
    {
        return new self($json['discount']);
    }

    public function __construct(int $discount)
    {
        $this->discount = $discount;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }
}
