<?php

namespace App\Task\Application\Queries;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ListTasksQueryHandler implements MessageHandlerInterface
{
    protected ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(ListTasksQuery $query): array
    {
        $qb = $this->getQueryBuilder();

        $qb->select('*')
            ->from('task');

        if ($query->getLimit()) {
            $qb->setMaxResults($query->getLimit());
        }
        if ($query->getOffset()) {
            $qb->setFirstResult($query->getOffset());
        }

        return $qb->execute()->fetchAllAssociative();
    }

    protected function getQueryBuilder(): QueryBuilder
    {
        return $this->doctrine->getConnection()->createQueryBuilder();
    }
}
