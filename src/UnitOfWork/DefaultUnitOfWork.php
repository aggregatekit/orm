<?php declare(strict_types=1);

namespace AggregateKit\Orm\UnitOfWork;

use AggregateKit\Orm\Driver\DriverInterface;
use AggregateKit\Orm\Entity;
use AggregateKit\Orm\Mapping\MappingLoader;

final class DefaultUnitOfWork implements UnitOfWorkInterface
{
    /** @var Entity[] */
    private array $newEntities = [];

    public function __construct(
        private readonly MappingLoader $mappingLoader,
        private readonly DriverInterface $driver,
    ) {}

    public function registerNew(Entity $entity): void
    {
        $this->newEntities[] = $entity;
    }

    public function commit(): void
    {
        foreach ($this->newEntities as $entity) {
            $mapping = $this->mappingLoader->loadMapping($entity::class);
            $this->driver->insert($entity, $mapping);
        }

        $this->newEntities = [];
    }
}