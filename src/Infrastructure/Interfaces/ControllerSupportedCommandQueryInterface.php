<?php

namespace App\Infrastructure\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface ControllerSupportedCommandQueryInterface
{
    public static function fromRequest(Request $request): self;
}
