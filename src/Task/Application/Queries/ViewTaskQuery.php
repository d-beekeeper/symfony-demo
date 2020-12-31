<?php

namespace App\Task\Application\Queries;

use Symfony\Component\Uid\Uuid;

class ViewTaskQuery
{
    protected Uuid $taskId;

    public function __construct(Uuid $taskId)
    {
        $this->taskId = $taskId;
    }

    public function getTaskId(): Uuid
    {
        return $this->taskId;
    }
}
