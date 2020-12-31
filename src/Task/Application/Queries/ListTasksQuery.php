<?php

namespace App\Task\Application\Queries;

use App\Infrastructure\Interfaces\ControllerSupportedCommandQueryInterface;
use Symfony\Component\HttpFoundation\Request;

class ListTasksQuery implements ControllerSupportedCommandQueryInterface
{

    protected ?int $limit = null;
    protected ?int $offset = null;

    public static function fromRequest(Request $request)
    {
        return new static(
            $request->get('limit'),
            $request->get('offset'),
        );
    }

    public function __construct(?int $limit = null, ?int $offset = null)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }
}
