<?php declare(strict_types=1);

namespace AggregateKit\Orm;
interface EntityManagerInterface
{
    public function persist(object $entity): void;

    public function flush(): void;

    public function clear(): void;
}