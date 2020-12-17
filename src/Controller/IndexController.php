<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    /**
     * @Route("/index", methods={"GET"})
     */
    public function index()
    {
        return new JsonResponse('hello world');
    }
}
