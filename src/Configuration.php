<?php declare(strict_types=1);

namespace AggregateKit\Orm;

use AggregateKit\Orm\Driver\DriverInterface;

final readonly class Configuration
{
    /** @param array<string, string> $mapping */
    public function __construct(
        private(set) DriverInterface $driver,
        private(set) bool $debug = false,
        private(set) bool $cacheMapping = false,
        private(set) array $mapping = [],
        private(set) string $mappingFileSuffix = 'map.php',
    ) {}
}