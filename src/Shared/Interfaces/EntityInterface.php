<?php

namespace App\Shared\Interfaces;

use Symfony\Component\Uid\Uuid;

interface EntityInterface
{
    public function getId(): Uuid;

    public function equals(EntityInterface $entity): bool;
}
