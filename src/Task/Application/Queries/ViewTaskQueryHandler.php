<?php

namespace App\Task\Application\Queries;

use App\Shared\Exceptions\NotFoundException;
use App\Shared\Exceptions\SearchErrorException;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ViewTaskQueryHandler implements MessageHandlerInterface
{
    protected ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(ViewTaskQuery $query): array
    {
        $qb = $this->getQueryBuilder();
        $qb->select('*')
            ->from('task')
            ->where('id = :id')
            ->setParameter('id', $query->getTaskId());

        $result = $qb->execute()->fetchAssociative();
        if ($result === false) {
            throw new SearchErrorException();
        }
        if (!$result) {
            throw new NotFoundException();
        }
        return $result;
    }

    protected function getQueryBuilder(): QueryBuilder
    {
        return $this->doctrine->getConnection()->createQueryBuilder();
    }
}
