<?php

namespace App\Commands;

class HelloCommandHandler
{
    public function __invoke(HelloCommand $command): string
    {
        return $command->getPhrase();
    }
}
