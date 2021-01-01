<?php

namespace App\Task\Application\Commands;

use App\Task\Domain\Aggregates\Task\Task;
use App\Task\Domain\ValueObjects\EmailAddress;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\Uuid;

class CreateTaskCommandHandler implements MessageHandlerInterface
{
    protected ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(CreateTaskCommand $command): Uuid
    {
        $task = Task::create(
            $command->getTitle(),
            $command->getDescription(),
            new EmailAddress($command->getResponsibleEmail()),
        );
        $em = $this->doctrine->getManager();
        $em->persist($task);
        $em->flush();
        return $task->getId();
    }
}
