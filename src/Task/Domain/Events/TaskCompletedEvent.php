<?php

namespace App\Task\Domain\Events;

use App\Shared\Interfaces\DomainEventInterface;
use App\Task\Domain\ValueObjects\EmailAddress;
use Symfony\Component\Uid\Uuid;

class TaskCompletedEvent implements DomainEventInterface
{
    protected Uuid $taskId;
    protected string $title;
    protected string $description;
    protected EmailAddress $responsibleEmail;

    public function __construct(Uuid $taskId, string $title, string $description, EmailAddress $responsibleEmail)
    {
        $this->taskId = $taskId;
        $this->title = $title;
        $this->description = $description;
        $this->responsibleEmail = $responsibleEmail;
    }

    public function getTaskId(): Uuid
    {
        return $this->taskId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getResponsibleEmail(): EmailAddress
    {
        return $this->responsibleEmail;
    }
}
