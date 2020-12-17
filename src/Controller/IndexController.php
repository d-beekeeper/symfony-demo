<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    /**
     * @Route("/index", methods={"GET"})
     */
    public function index(ManagerRegistry $doctrine)
    {
        return new JsonResponse('hello world');
    }
}
