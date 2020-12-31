<?php

namespace App\Shared\Interfaces;

interface ValueObjectInterface
{
    public function equals(ValueObjectInterface $valueObject): bool;
}
