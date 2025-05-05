<?php

namespace AggregateKit\Orm\Tests\Mapping;

use AggregateKit\Orm\Mapping\Mapping;
use AggregateKit\Orm\Mapping\MappingBuilder;
use AggregateKit\Orm\Tests\Mapping\Fixtures\Product;
use PHPUnit\Framework\TestCase;

final class MappingTest extends TestCase
{
    public function testThrowsWhenClassDoesNotExist(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Mapping::for('AggregateKit\\Orm\\Tests\\Mapping\\DoesNotExist');
    }

    public function testThrowsWhenClassDoesNotImplementEntity(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Mapping::for(\stdClass::class);
    }

    public function testReturnsBuilderWhenClassImplementsEntity(): void
    {
        $builder = Mapping::for(Product::class);
        $this->assertInstanceOf(MappingBuilder::class, $builder);
    }
}