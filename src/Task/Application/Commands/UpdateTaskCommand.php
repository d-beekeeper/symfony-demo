<?php

namespace App\Task\Application\Commands;

use App\Task\Domain\Aggregates\Task\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateTaskCommand
{
    protected Task $task;

    /**
     * @Assert\NotBlank(normalizer="trim")
     * @Assert\Length(max=255)
     */
    protected string $title;

    /**
     * @Assert\NotBlank(normalizer="trim")
     */
    protected string $description;

    public static function fromRequest(Request $request, Task $task): self
    {
        return new self(
            $task,
            trim($request->get('title', '')),
            trim($request->get('description', '')),
        );
    }

    public function __construct(Task $task, string $title, string $description)
    {
        $this->task = $task;
        $this->title = $title;
        $this->description = $description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTask(): Task
    {
        return $this->task;
    }
}
