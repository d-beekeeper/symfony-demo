<?php

namespace App\Task\Application\Commands;

use App\Task\Domain\Aggregates\Task\Task;

class CompleteTaskCommand
{
    protected Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getTask(): Task
    {
        return $this->task;
    }
}
