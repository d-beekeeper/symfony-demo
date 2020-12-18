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
        $client->request('POST', '/generate', [], [], [], json_encode([
            'discount' => 100,
        ]));

        $response = $this->assertJsonResponse($client->getResponse());
        self::assertNotEmpty($response['code']);
        self::assertTrue(strlen($response['code']) === 7);
    }
}
