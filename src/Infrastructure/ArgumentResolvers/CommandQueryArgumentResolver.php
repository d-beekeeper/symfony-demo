<?php

namespace App\Infrastructure\ArgumentResolvers;

use App\Infrastructure\Interfaces\ControllerSupportedCommandQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class CommandQueryArgumentResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return is_a($argument->getType(), ControllerSupportedCommandQueryInterface::class, true);
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        /** @var ControllerSupportedCommandQueryInterface|string $class */
        $class = $argument->getType();

        yield $class::fromRequest($request);
    }
}
