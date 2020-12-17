<?php

namespace App\Tests\Controller;

use App\Tests\ClientTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    use ClientTrait;

    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/index');
        $response = $this->assertJsonResponse($client->getResponse());
        $this->assertSame('hello world', $response);
    }
}
