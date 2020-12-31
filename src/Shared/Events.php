<?php

namespace App\Shared;

use App\Shared\Interfaces\DomainEventInterface;

class Events
{
    /**
     * @var DomainEventInterface[]
     */
    private static array $events = [];

    public static function add(DomainEventInterface $event)
    {
        self::$events[] = $event;
    }

    /**
     * @return DomainEventInterface[]
     */
    public static function fetch(): array
    {
        $events = self::$events;
        self::$events = [];
        return $events;
    }
}
