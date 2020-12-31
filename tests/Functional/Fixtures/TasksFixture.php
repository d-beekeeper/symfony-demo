<?php

namespace App\Tests\Functional\Fixtures;

use App\Task\Domain\Aggregates\Task\Task;
use App\Task\Domain\ValueObjects\EmailAddress;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TasksFixture extends Fixture
{
    public const TASK_FIRST_ACTIVE = 'task_first';
    public const TASK_SECOND_COMPLETED = 'task_second';

    public function load(ObjectManager $manager)
    {
        $task1 = new Task(
            'first task',
            'first some description',
            new EmailAddress('aa@bb.cc')
        );
        $manager->persist($task1);
        $this->addReference(self::TASK_FIRST_ACTIVE, $task1);

        $task2 = new Task(
            'second task',
            'second some description',
            new EmailAddress('dd@ee.ff'),
            false,
        );
        $manager->persist($task2);
        $this->addReference(self::TASK_SECOND_COMPLETED, $task2);

        $manager->persist(new Task(
            'third task',
            'third some description',
            new EmailAddress('gg@hh.ii')
        ));

        $manager->flush();
    }
}
