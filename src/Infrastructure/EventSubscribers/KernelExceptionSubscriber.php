<?php

namespace App\Infrastructure\EventSubscribers;

use App\Shared\Exceptions\DomainException;
use App\Shared\Exceptions\NotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
        $e = $event->getThrowable();
        if ($e instanceof HandlerFailedException && $e->getPrevious()) {
            $e = $e->getPrevious();
        }

        $body = [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ];

        switch (true) {
            case $e instanceof HttpException:
                $event->setResponse(new JsonResponse($body, $e->getStatusCode(), $e->getHeaders()));
                break;
            case $e instanceof DomainException || $e instanceof ValidationFailedException:
                $event->setResponse(new JsonResponse($body, 400));
                break;
            case $e instanceof NotFoundException:
                $event->setResponse(new JsonResponse($body, 404));
                break;
            default:
                $event->setResponse(new JsonResponse($body, 500));
        }
    }
}
