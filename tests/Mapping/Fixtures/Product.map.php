<?php

use AggregateKit\Orm\Mapping\Mapping;
use AggregateKit\Orm\Tests\Mapping\Fixtures\Product;

return Mapping::for(Product::class)
    ->table('products')
    ->identifier('id')
    ->field('name')
    ->field('price')
    ->build();