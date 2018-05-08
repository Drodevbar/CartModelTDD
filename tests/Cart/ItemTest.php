<?php

declare(strict_types = 1);

namespace Gwo\Recruitment\Tests\Cart;

use Gwo\Recruitment\Cart\Item;
use Gwo\Recruitment\Entity\Product;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    /**
     * @test
     */
    public function itAcceptsConstructorArgumentsAndReturnsData()
    {
        $product = new Product();
        $product->setUnitPrice(10000);
        $item = new Item($product, 10);

        $this->assertEquals($product, $item->getProduct());
        $this->assertEquals(10, $item->getQuantity());
        $this->assertEquals(100000, $item->getTotalPrice());
    }

    /**
     * @test
     * @expectedException \Gwo\Recruitment\Cart\Exception\QuantityTooLowException
     */
    public function constructorThrowsExceptionWhenQuantityIsTooLow()
    {
        $product = new Product();
        $product->setMinimumQuantity(10);

        new Item($product, 9);
    }

    /**
     * @test
     * @expectedException \Gwo\Recruitment\Cart\Exception\QuantityTooLowException
     */
    public function itThrowsExceptionWhenSettingTooLowQuantity()
    {
        $product = new Product();
        $product->setMinimumQuantity(10);

        $item = new Item($product, 10);
        $item->setQuantity(9);
    }
}
