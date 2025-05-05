<?php

namespace AggregateKit\Orm\Mapping;

interface MappingLoader
{
    public function loadMapping(string $className): Mapping;
}