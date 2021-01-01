<?php

namespace App\Task\Application\Commands;

use App\Infrastructure\Interfaces\ControllerSupportedCommandQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTaskCommand implements ControllerSupportedCommandQueryInterface
{
    /**
     * @Assert\NotBlank(normalizer="trim")
     * @Assert\Length(max=255)
     */
    protected string $title;

    /**
     * @Assert\NotBlank(normalizer="trim")
     */
    protected string $description;

    /**
     * @Assert\NotBlank(normalizer="trim")
     * @Assert\Email(normalizer="trim")
     * @Assert\Length(max=320)
     */
    protected string $responsibleEmail;

    public static function fromRequest(Request $request): self
    {
        return new self(
            trim($request->get('title', '')),
            trim($request->get('description', '')),
            trim($request->get('responsibleEmail', ''))
        );
    }

    public function __construct(string $title, string $description, string $responsibleEmail)
    {
        $this->title = $title;
        $this->description = $description;
        $this->responsibleEmail = $responsibleEmail;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getResponsibleEmail(): string
    {
        return $this->responsibleEmail;
    }
}
