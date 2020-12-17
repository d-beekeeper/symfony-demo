<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;

trait ClientTrait
{
    /**
     * @param Response $response
     * @param int $expectedStatusCode
     * @return mixed Json decoded response body.
     */
    public function assertJsonResponse(Response $response, int $expectedStatusCode = 200)
    {
        $this->assertTrue($response->headers->has('Content-Type'), 'Request does not contains "Content-Type" header.');
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'Content-Type header is not equals "application/json"');
        $body = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertEquals($expectedStatusCode, $response->getStatusCode(), print_r($body, true));
        return $body;
    }
}
