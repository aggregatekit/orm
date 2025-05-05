<?php declare(strict_types=1);

namespace AggregateKit\Orm;

use AggregateKit\Orm\UnitOfWork\UnitOfWorkInterface;

final class EntityManager implements EntityManagerInterface
{
    public function __construct(
        private UnitOfWorkInterface $unitOfWork
    ) {}

    public function persist(object $entity): void
    {
        // TODO: Implement persist() method.
    }

    public function flush(): void
    {
        // TODO: Implement flush() method.
    }

    public function clear(): void
    {
        // TODO: Implement clear() method.
    }
}