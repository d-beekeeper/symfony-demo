<?php

namespace App\Task\Application\Commands;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateTaskCommandHandler implements MessageHandlerInterface
{
    protected ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(UpdateTaskCommand $command)
    {
        $task = $command->getTask();
        $task->setTitle($command->getTitle());
        $task->setDescription($command->getDescription());
        $this->doctrine->getManager()->flush();
    }
}
