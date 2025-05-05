<?php declare(strict_types=1);

namespace AggregateKit\Orm\UnitOfWork;

use AggregateKit\Orm\Entity;

interface UnitOfWorkInterface
{
    public function registerNew(Entity $entity): void;
    public function commit(): void;
}