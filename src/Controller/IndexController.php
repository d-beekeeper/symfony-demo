<?php

namespace App\Controller;

use App\Commands\HelloCommand;
use App\Commands\HelloCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class IndexController
{
    /**
     * @Route("/index", methods={"GET"})
     */
    public function index(Request $request, HelloCommandHandler $handler, ValidatorInterface $validator)
    {
        $command = HelloCommand::fromRequest($request);
        $errors = $validator->validate($command);
        if ($errors->count()) {
            return new JsonResponse(['error' => 'validation error']);
        }
        return new JsonResponse($handler($command));
    }
}
