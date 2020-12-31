<?php

namespace App\Task\Application\Commands;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CompleteTaskCommandHandler implements MessageHandlerInterface
{
    protected ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(CompleteTaskCommand $command)
    {
        $task = $command->getTask();
        $task->complete();
        $this->doctrine->getManager()->flush();
    }
}
