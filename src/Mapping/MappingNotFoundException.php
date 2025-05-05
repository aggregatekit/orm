<?php declare(strict_types=1);

namespace AggregateKit\Orm\Mapping;

final class MappingNotFoundException extends \RuntimeException
{
    public static function forMissingClass(string $className): self
    {
        return new self(\sprintf(
            'Mapping file not registered for entity class "%s". Please define it explicitly in your configuration.',
            $className
        ));
    }

    public static function forMissingFile(string $className, string $filePath): self
    {
        return new self(\sprintf(
            'Mapping file "%s" does not exist for entity class "%s".',
            $filePath,
            $className
        ));
    }

    public static function forInvalidMapping(string $className, string $filePath): self
    {
        return new self(\sprintf(
            'Mapping file "%s" for class "%s" must return an instance of AggregateKit\\Orm\\Mapping\\Mapping.',
            $filePath,
            $className
        ));
    }
}