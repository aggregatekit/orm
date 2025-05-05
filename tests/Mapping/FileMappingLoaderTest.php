<?php declare(strict_types=1);

namespace AggregateKit\Orm\Tests\Mapping;

use AggregateKit\Orm\Tests\Mapping\Fixtures\Product;
use PHPUnit\Framework\TestCase;
use AggregateKit\Orm\Mapping\FileMappingLoader;
use AggregateKit\Orm\Mapping\Mapping;
use AggregateKit\Orm\Mapping\MappingNotFoundException;
use AggregateKit\Orm\Configuration;
use AggregateKit\Orm\Driver\DriverInterface;

final class FileMappingLoaderTest extends TestCase
{
    public function testThrowsWhenMappingIsNotRegistered(): void
    {
        $loader = new FileMappingLoader(new Configuration(
            driver: $this->createStub(DriverInterface::class),
            debug: true,
            cacheMapping: false,
            mapping: [],
            mappingFileSuffix: 'map.php',
        ));

        $this->expectException(MappingNotFoundException::class);
        $loader->loadMapping('App\\Entity\\Unmapped');
    }

    public function testThrowsWhenMappingFileDoesNotExist(): void
    {
        $loader = new FileMappingLoader(new Configuration(
            driver: $this->createStub(DriverInterface::class),
            debug: true,
            cacheMapping: false,
            mapping: [
                'MissingClass' => __DIR__ . '/fixtures/does_not_exist.map.php'
            ],
            mappingFileSuffix: 'map.php',
        ));

        $this->expectException(MappingNotFoundException::class);
        $loader->loadMapping('MissingClass');
    }

    public function testThrowsWhenMappingFileReturnsInvalidType(): void
    {
        $loader = new FileMappingLoader(new Configuration(
            driver: $this->createStub(DriverInterface::class),
            debug: true,
            cacheMapping: false,
            mapping: ['InvalidClass' => __DIR__ . '/fixtures/Invalid.map.php'],
            mappingFileSuffix: 'map.php',
        ));

        $this->expectException(MappingNotFoundException::class);
        $loader->loadMapping('InvalidClass');
    }

    public function testWarnsWhenMappingNotCachedAndCachingEnabled(): void
    {
        // Temporarily override error handler to catch trigger_error
        $warned = false;
        set_error_handler(function ($errno, $errstr) use (&$warned) {
            if (str_contains($errstr, 'not cached via OPcache')) {
                $warned = true;
            }
            return true; // suppress output
        });

        $loader = new FileMappingLoader(
            new Configuration(
                driver: $this->createStub(DriverInterface::class),
                debug: true,
                cacheMapping: true, // enables OPcache check
                mapping: [Product::class => __DIR__ . '/fixtures/Product.map.php'],
                mappingFileSuffix: 'map.php',
            ), fn (string $file): bool => false // simulate "not cached"
        );

        $loader->loadMapping(Product::class);

        restore_error_handler();

        $this->assertTrue($warned, 'Expected OPcache warning was not triggered.');
    }

    public function testLoadsValidMappingFromRegisteredFile(): void
    {
        $loader = new FileMappingLoader(
            new Configuration(
                driver: $this->createStub(DriverInterface::class),
                debug: true,
                cacheMapping: false,
                mapping: [Product::class => __DIR__ . '/Fixtures/Product.map.php'],
                mappingFileSuffix: 'map.php',
            )
        );

        $mapping = $loader->loadMapping(Product::class);

        $this->assertInstanceOf(Mapping::class, $mapping);
        $this->assertSame('products', $mapping->tableName);
    }
}