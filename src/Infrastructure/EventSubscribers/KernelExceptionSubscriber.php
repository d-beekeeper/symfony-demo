<?php

namespace App\Infrastructure\EventSubscribers;

use App\Shared\Exceptions\DomainException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;

class KernelExceptionSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException'],
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HandlerFailedException && $exception->getPrevious()) {
            $exception = $exception->getPrevious();
        }

        if ($exception instanceof DomainException || $exception instanceof ValidationFailedException) {
            $code = 400;
        } else {
            $code = 500;
        }

        $event->setResponse(new JsonResponse([
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ], $code));
    }
}
