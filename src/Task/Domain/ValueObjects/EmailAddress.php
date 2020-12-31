<?php

namespace App\Task\Domain\ValueObjects;

use App\Shared\Interfaces\ValueObjectInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class EmailAddress implements ValueObjectInterface
{
    /**
     * @ORM\Column(type="string", length=320)
     */
    protected string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function equals(ValueObjectInterface $valueObject): bool
    {
        if (!$valueObject instanceof EmailAddress) {
            return false;
        }
        return $this->email === $valueObject->email;
    }
}
