<?php

namespace App\Commands;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class HelloCommand
{
    /**
     * @Assert\NotBlank()
     */
    private string $phrase;

    public static function fromRequest(Request $request): self
    {
        $command = new self();
        $command->phrase = $request->get('phrase', '');
        return $command;
    }

    public function getPhrase(): string
    {
        return $this->phrase;
    }
}
