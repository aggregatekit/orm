<?php

namespace AggregateKit\Orm\Mapping;

final class MappingBuilder
{
    private string $tableName;
    private string $identifierField;
    /** @var string[] */
    private array $fields;

    public function __construct(private(set) readonly string $className) {
        $this->fields = [];
    }

    public function table(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function identifier(string $field): self
    {
        $this->identifierField = $field;
        return $this;
    }

    public function field(string $field): self
    {
        $this->fields[] = $field;
        return $this;
    }

    public function build(): Mapping
    {
        return new Mapping(
            $this->className,
            $this->tableName,
            $this->identifierField,
            $this->fields
        );
    }
}