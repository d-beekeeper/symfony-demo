<?php

namespace App\Infrastructure\Messenger\Middleware;

use App\Shared\Events;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class DispatchDomainEventsMiddleware implements MiddlewareInterface
{
    protected MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $envelope = $stack->next()->handle($envelope, $stack);
        foreach (Events::fetch() as $event) {
            $this->eventBus->dispatch($event);
        }
        return $envelope;
    }
}
