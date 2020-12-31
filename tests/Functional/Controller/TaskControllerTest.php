<?php

namespace App\Tests\Functional\Controller;

use App\Task\Domain\Aggregates\Task\Task;
use App\Tests\ClientTrait;
use App\Tests\Functional\Fixtures\TasksFixture;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;

class TaskControllerTest extends WebTestCase
{
    use ClientTrait;
    use FixturesTrait;

    public function testList()
    {
        $client = static::createClient();
        $this->loadFixtures([TasksFixture::class]);
        $client->request('GET', '/task');
        $response = $this->assertJsonResponse($client->getResponse());
        self::assertCount(3, $response);
    }

    public function testView()
    {
        $client = static::createClient();
        $repo = $this->loadFixtures([TasksFixture::class])->getReferenceRepository();
        /** @var Task $task */
        $task = $repo->getReference(TasksFixture::TASK_FIRST_ACTIVE);
        $client->request('GET', '/task/' . $task->getId());
        $response = $this->assertJsonResponse($client->getResponse());
        self::assertSame([
            'id' => (string)$task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'is_active' => $task->isActive(),
            'responsible_email' => (string)$task->getResponsibleEmail(),
        ], $response);;
    }

    public function testCreate()
    {
        $client = static::createClient();
        $client->enableProfiler();
        $client->request('POST', '/task', [
            'title' => 'test task',
            'description' => 'test description',
            'responsibleEmail' => 'someperson@email.com'
        ]);
        $response = $this->assertJsonResponse($client->getResponse());
        self::assertArraySubset([
            'title' => 'test task',
            'description' => 'test description',
            'is_active' => true,
            'responsible_email' => 'someperson@email.com',
        ], $response);

        /** @var MessageDataCollector $mailCollector */
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        self::assertSame(1, $mailCollector->getMessageCount());
        /** @var \Swift_Message $message */
        $message = $mailCollector->getMessages()[0];
        self::assertSame('test task', $message->getSubject());
    }

    public function testCreateFail()
    {
        $client = static::createClient();
        $client->request('POST', '/task', [
            'title' => '   ',
            'description' => 'test description',
            'responsibleEmail' => 'someperson@email.com'
        ]);
        $this->assertJsonResponse($client->getResponse(), 400);
    }

    public function testUpdate()
    {
        $client = static::createClient();
        $repo = $this->loadFixtures([TasksFixture::class])->getReferenceRepository();
        /** @var Task $task */
        $task = $repo->getReference(TasksFixture::TASK_FIRST_ACTIVE);
        $client->request('PUT', '/task/' . $task->getId(), [
            'title' => 'some new title',
            'description' => 'some new description',
        ]);
        $response = $this->assertJsonResponse($client->getResponse());
        self::assertSame([
            'id' => (string)$task->getId(),
            'title' => 'some new title',
            'description' => 'some new description',
            'is_active' => $task->isActive(),
            'responsible_email' => (string)$task->getResponsibleEmail(),
        ], $response);;
    }

    public function testUpdateFail()
    {
        $client = static::createClient();
        $repo = $this->loadFixtures([TasksFixture::class])->getReferenceRepository();
        /** @var Task $task */
        $task = $repo->getReference(TasksFixture::TASK_SECOND_COMPLETED);
        $client->request('PUT', '/task/' . $task->getId(), [
            'title' => 'some new title',
            'description' => 'some new description',
        ]);
        $response = $this->assertJsonResponse($client->getResponse(), 400);
        self::assertSame('you cannot edit completed task', $response['message']);
    }

    public function testComplete()
    {
        $client = static::createClient();
        $repo = $this->loadFixtures([TasksFixture::class])->getReferenceRepository();
        /** @var Task $task */
        $task = $repo->getReference(TasksFixture::TASK_FIRST_ACTIVE);
        $client->request('PUT', "/task/{$task->getId()}/complete");
        $response = $this->assertJsonResponse($client->getResponse());
        self::assertArraySubset([
            'id' => (string)$task->getId(),
            'is_active' => false,
        ], $response);;
    }

    public function testCompleteFail()
    {
        $client = static::createClient();
        $repo = $this->loadFixtures([TasksFixture::class])->getReferenceRepository();
        /** @var Task $task */
        $task = $repo->getReference(TasksFixture::TASK_SECOND_COMPLETED);
        $client->request('PUT', "/task/{$task->getId()}/complete");
        $response = $this->assertJsonResponse($client->getResponse(), 400);
        self::assertSame('this task is already completed', $response['message']);
    }
}
