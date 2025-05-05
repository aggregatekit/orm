<?php declare(strict_types=1);

namespace AggregateKit\Orm\Driver;

use AggregateKit\Orm\Entity;
use AggregateKit\Orm\Mapping\Mapping;

interface DriverInterface
{
    public function insert(Entity $entity, Mapping $mapping): void;
    public function update(Entity $entity, Mapping $mapping): void;
    public function delete(Entity $entity, Mapping $mapping): void;
}