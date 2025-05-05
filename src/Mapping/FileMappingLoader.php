<?php declare(strict_types=1);

namespace AggregateKit\Orm\Mapping;

use AggregateKit\Orm\Configuration;

final class FileMappingLoader implements MappingLoader
{
    public function __construct(
        private readonly Configuration $configuration,
        private readonly ?\Closure $opcacheChecker = null
    ) {}

    public function loadMapping(string $className): Mapping
    {
        $mappingFile = $this->configuration->mapping[$className] ?? null;

        if ($mappingFile === null) {
            throw MappingNotFoundException::forMissingClass($className);
        }

        if (!file_exists($mappingFile)) {
            throw MappingNotFoundException::forMissingFile($className, $mappingFile);
        }

        $checker = $this->opcacheChecker;

        // fallback to native checker if available
        if ($checker === null && \function_exists('opcache_is_script_cached')) {
            $checker = opcache_is_script_cached(...);
        }

        if (
            $this->configuration->cacheMapping &&
            $checker !== null &&
            !$checker($mappingFile)
        ) {
            trigger_error(\sprintf(
                'Mapping file "%s" is not cached via OPcache. Consider preloading it in production.',
                $mappingFile
            ), E_USER_WARNING);
        }

        $mapping = require $mappingFile;

        if (!$mapping instanceof Mapping) {
            throw MappingNotFoundException::forInvalidMapping($className, $mappingFile);
        }

        return $mapping;
    }
}