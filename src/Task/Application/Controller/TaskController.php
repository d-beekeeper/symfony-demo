<?php

namespace App\Task\Application\Controller;

use App\Infrastructure\Messenger\HandleTrait;
use App\Task\Application\Commands\CompleteTaskCommand;
use App\Task\Application\Commands\CreateTaskCommand;
use App\Task\Application\Commands\UpdateTaskCommand;
use App\Task\Application\Queries\ViewTaskQuery;
use App\Task\Application\Queries\ListTasksQuery;
use App\Task\Domain\Aggregates\Task\Task;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;


/**
 * @Route("/task", name="task_")
 */
class TaskController
{
    use HandleTrait;

    /**
     * @Route(methods={"GET"}, name="list")
     */
    public function list(ListTasksQuery $query, MessageBusInterface $queryBus)
    {
        return new JsonResponse($this->handle($query, $queryBus));
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="view")
     */
    public function view(string $id, MessageBusInterface $queryBus)
    {
        return new JsonResponse($this->handle(new ViewTaskQuery(Uuid::fromString($id)), $queryBus));
    }

    /**
     * @Route(methods={"POST"}, name="create")
     */
    public function create(CreateTaskCommand $command, MessageBusInterface $queryBus, MessageBusInterface $commandBus)
    {
        $taskId = $this->handle($command, $commandBus);
        return new JsonResponse($this->handle(new ViewTaskQuery($taskId), $queryBus));
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="update")
     */
    public function update(Task $task, UpdateTaskCommand $command, MessageBusInterface $queryBus, MessageBusInterface $commandBus)
    {
        $command->setTask($task);
        $commandBus->dispatch($command);
        return new JsonResponse($this->handle(new ViewTaskQuery($task->getId()), $queryBus));
    }

    /**
     * @Route("/{id}/complete", methods={"PUT"}, name="complete")
     */
    public function complete(Task $task, CompleteTaskCommand $command, MessageBusInterface $queryBus, MessageBusInterface $commandBus)
    {
        $command->setTask($task);
        $commandBus->dispatch($command);
        return new JsonResponse($this->handle(new ViewTaskQuery($task->getId()), $queryBus));
    }
}
