<?php declare(strict_types=1);

namespace AggregateKit\Orm\Mapping;

use AggregateKit\Orm\Entity;

use function sprintf;

final readonly class Mapping
{
    /** @param string[] $fields */
    public function __construct(
        public string $className,
        public string $tableName,
        public string $identifierField,
        public array  $fields
    ) {}

    public static function for(string $className): MappingBuilder
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException(
                sprintf('Class %s does not exist', $className)
            );
        }

        if (!is_subclass_of($className, Entity::class)) {
            throw new \InvalidArgumentException(
                sprintf('Class %s must extend AggregateKit\\Orm\\Entity', Entity::class)
            );
        }

        return new MappingBuilder($className);
    }
}