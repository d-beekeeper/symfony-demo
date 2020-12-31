<?php

namespace App\Tests\Unit;

use App\Shared\Events;
use App\Task\Domain\Aggregates\Task\CompletedTaskCannotBeEditedException;
use App\Task\Domain\Aggregates\Task\Task;
use App\Task\Domain\Aggregates\Task\TaskAlreadyCompletedException;
use App\Task\Domain\Events\TaskCompletedEvent;
use App\Task\Domain\Events\TaskCreatedEvent;
use App\Task\Domain\ValueObjects\EmailAddress;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class TaskTest extends TestCase
{

    public function tearDown()
    {
        Events::fetch();
    }

    public function testCreate()
    {
        $task = Task::create('test title', 'test description', new EmailAddress('aa@bb.cc'));
        self::assertInstanceOf(Uuid::class, $task->getId());
        self::assertSame('test title', $task->getTitle());
        self::assertSame('test description', $task->getDescription());
        self::assertSame('aa@bb.cc', (string)$task->getResponsibleEmail());
        self::assertTrue($task->isActive());
        self::assertFalse($task->isCompleted());
        self::assertInstanceOf(TaskCreatedEvent::class, Events::fetch()[0]);

    }

    public function testUpdate()
    {
        $task = Task::create('test title', 'test description', new EmailAddress('aa@bb.cc'));
        $task->setTitle('new title');
        $task->setDescription('new description');
        self::assertSame('new title', $task->getTitle());
        self::assertSame('new description', $task->getDescription());
    }

    public function testComplete()
    {
        $task = Task::create('test title', 'test description', new EmailAddress('aa@bb.cc'));
        $task->complete();
        self::assertTrue($task->isCompleted());
        self::assertFalse($task->isActive());

        $events = Events::fetch();
        self::assertInstanceOf(TaskCreatedEvent::class, $events[0]);
        self::assertInstanceOf(TaskCompletedEvent::class, $events[1]);
    }

    public function testThatCompletedTaskCannotBeEdited()
    {
        $task = Task::create('test title', 'test description', new EmailAddress('aa@bb.cc'));
        $task->complete();
        $this->expectException(CompletedTaskCannotBeEditedException::class);
        $task->setTitle('new title');
    }

    public function testThatCompletedTaskCannotBeCompletedAgain()
    {
        $task = Task::create('test title', 'test description', new EmailAddress('aa@bb.cc'));
        $task->complete();
        $this->expectException(TaskAlreadyCompletedException::class);
        $task->complete();
    }
}
