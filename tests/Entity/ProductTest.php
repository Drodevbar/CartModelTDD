<?php

declare(strict_types = 1);

namespace Gwo\Recruitment\Tests\Entity;

use Gwo\Recruitment\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itThrowsExceptionForInvalidUnitPrice()
    {
        $product = new Product();
        $product->setUnitPrice(0);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itThrowsExceptionForInvalidMinimumQuantity()
    {
        $product = new Product();
        $product->setMinimumQuantity(0);
    }
}
