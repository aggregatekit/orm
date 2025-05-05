<?php declare(strict_types=1);

namespace AggregateKit\Orm\Tests\Mapping;

use AggregateKit\Orm\Mapping\MappingBuilder;
use AggregateKit\Orm\Tests\Mapping\Fixtures\Product;
use PHPUnit\Framework\TestCase;

final class MappingBuilderTest extends TestCase
{
    public function testFluentApiReturnsSelf(): void
    {
        $builder = new MappingBuilder(Product::class);

        $result = $builder
            ->table('products')
            ->identifier('id')
            ->field('name')
            ->field('price');

        $this->assertEquals('products', $result->tableName);
        $this->assertEquals('id', $result->identifierField);
        foreach ($result->fields as $field) {
            $this->assertContains($field, ['name', 'price']);
        }
    }

    public function testFieldMethodAccumulatesFields(): void
    {
        $builder = new MappingBuilder(Product::class);
        $builder->field('name')->field('price');

        $mapping = $builder
            ->table('products')
            ->identifier('id')
            ->build();

        $this->assertSame(['name', 'price'], $mapping->fields);
    }

    public function testBuildReturnsMapping(): void
    {
        $builder = new MappingBuilder(Product::class);
        $builder
            ->table('products')
            ->identifier('id')
            ->field('name');

        $mapping = $builder->build();

        $this->assertSame(Product::class, $mapping->className);
        $this->assertSame('products', $mapping->tableName);
        $this->assertSame('id', $mapping->identifierField);
        $this->assertSame(['name'], $mapping->fields);
    }
}