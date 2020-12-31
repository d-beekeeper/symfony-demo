<?php

namespace App\Task\Application\EventSubscribers;

use App\Task\Domain\Events\TaskCreatedEvent;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TaskCreatedEventSubscriber implements MessageHandlerInterface
{
    protected \Swift_Mailer $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(TaskCreatedEvent $event)
    {
        $email = new \Swift_Message();
        $email->setTo((string)$event->getResponsibleEmail())
            ->setSubject($event->getTitle())
            ->setBody($event->getDescription());

        $this->mailer->send($email);
    }
}
