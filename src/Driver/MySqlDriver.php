<?php declare(strict_types=1);

namespace AggregateKit\Orm\Driver;

use AggregateKit\Orm\Entity;
use AggregateKit\Orm\Mapping\Mapping;

final class MySqlDriver implements DriverInterface
{

    public function insert(Entity $entity, Mapping $mapping): void
    {
        // TODO: Implement insert() method.
    }

    public function update(Entity $entity, Mapping $mapping): void
    {
        // TODO: Implement update() method.
    }

    public function delete(Entity $entity, Mapping $mapping): void
    {
        // TODO: Implement delete() method.
    }
}