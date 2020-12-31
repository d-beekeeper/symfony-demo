<?php

namespace App\Task\Application\Commands;

use App\Task\Domain\Aggregates\Task\Task;
use Symfony\Component\Uid\Uuid;

class CompleteTaskCommand
{
    protected Task $task;

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setTask(Task $task)
    {
        $this->task = $task;
    }
}
