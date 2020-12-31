<?php

namespace App\Task\Domain\Aggregates\Task;

use App\Shared\Events;
use App\Shared\Interfaces\EntityInterface;
use App\Task\Domain\Events\TaskCompletedEvent;
use App\Task\Domain\Events\TaskCreatedEvent;
use App\Task\Domain\ValueObjects\EmailAddress;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity()
 */
class Task implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    protected Uuid $id;

    /**
     * @ORM\Column(type="string")
     */
    protected string $title;

    /**
     * @ORM\Column(type="text")
     */
    protected string $description;

    /**
     * @ORM\Embedded(class="App\Task\Domain\ValueObjects\EmailAddress", columnPrefix="responsible_")
     */
    protected EmailAddress $responsibleEmail;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $isActive = true;

    public static function create(string $title, string $description, EmailAddress $responsibleEmail): Task
    {
        $task = new static($title, $description, $responsibleEmail);
        Events::add(new TaskCreatedEvent(
            $task->id,
            $task->title,
            $task->description,
            $task->responsibleEmail
        ));
        return $task;
    }

    public function __construct(string $title, string $description, EmailAddress $responsibleEmail, bool $isActive = true)
    {
        $this->id = Uuid::v4();
        $this->title = $title;
        $this->description = $description;
        $this->responsibleEmail = $responsibleEmail;
        $this->isActive = $isActive;
    }

    /**
     * @throws TaskAlreadyCompletedException
     */
    public function complete()
    {
        if ($this->isCompleted()) {
            throw new TaskAlreadyCompletedException('this task is already completed');
        }

        $this->isActive = false;
        Events::add(new TaskCompletedEvent(
            $this->id,
            $this->title,
            $this->description,
            $this->responsibleEmail,
        ));
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @throws CompletedTaskCannotBeEditedException
     */
    public function setTitle(string $title)
    {
        if ($this->isCompleted()) {
            throw new CompletedTaskCannotBeEditedException('you cannot edit completed task');
        }
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @throws CompletedTaskCannotBeEditedException
     */
    public function setDescription(string $description)
    {
        if ($this->isCompleted()) {
            throw new CompletedTaskCannotBeEditedException('you cannot edit completed task');
        }
        $this->description = $description;
    }

    public function getResponsibleEmail(): EmailAddress
    {
        return $this->responsibleEmail;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function isCompleted(): bool
    {
        return !$this->isActive;
    }

    public function equals(EntityInterface $entity): bool
    {
        if (!$entity instanceof Task) {
            return false;
        }
        return $this->id->equals($entity->id);
    }
}
