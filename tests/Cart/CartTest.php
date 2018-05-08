<?php

declare(strict_types = 1);

namespace Gwo\Recruitment\Tests\Cart;

use Gwo\Recruitment\Cart\Cart;
use Gwo\Recruitment\Entity\Product;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /**
     * @test
     */
    public function itAddsOneProduct()
    {
        $product = $this->buildTestProduct1();

        $cart = new Cart();
        $cart->addProduct($product, 1);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(15000, $cart->getTotalPrice());
        $this->assertEquals($product, $cart->getItem(0)->getProduct());
    }

    /**
     * @test
     */
    public function itRemovesExistingProduct()
    {
        $product1 = $this->buildTestProduct1();
        $product2 = $this->buildTestProduct2();

        $cart = new Cart();
        $cart
            ->addProduct($product1, 1)
            ->addProduct($product2, 1);

        $cart->removeProduct($product1);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(10000, $cart->getTotalPrice());
        $this->assertEquals($product2, $cart->getItem(0)->getProduct());
    }

    /**
     * @test
     */
    public function itIncreasesQuantityWhenAddingAnExistingProduct()
    {
        $product = $this->buildTestProduct1();

        $cart = new Cart();
        $cart
            ->addProduct($product, 1)
            ->addProduct($product, 2);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(45000, $cart->getTotalPrice());
    }

    /**
     * @test
     */
    public function itUpdatesQuantityOfAnExistingItem()
    {
        $product = $this->buildTestProduct1();

        $cart = new Cart();
        $cart
            ->addProduct($product, 1)
            ->setQuantity($product, 2);

        $this->assertEquals(30000, $cart->getTotalPrice());
        $this->assertEquals(2, $cart->getItem(0)->getQuantity());
    }

    /**
     * @test
     */
    public function itAddsANewItemWhileSettingQuantityForNonExistentItem()
    {
        $product = $this->buildTestProduct1();

        $cart = new Cart();
        $cart->setQuantity($product, 1);

        $this->assertEquals(15000, $cart->getTotalPrice());
        $this->assertCount(1, $cart->getItems());
    }

    /**
     * @test
     * @dataProvider getNonExistentItemIndexes
     * @expectedException \OutOfBoundsException
     */
    public function itThrowsExceptionWhileGettingNonExistentItem(int $index)
    {
        $product = $this->buildTestProduct1();

        $cart = new Cart();
        $cart->addProduct($product, 1);
        $cart->getItem($index);
    }

    /**
     * @test
     */
    public function removingNonExistentItemDoesNotRaiseException()
    {
        $cart = new Cart();
        $cart->removeProduct(new Product());

        $this->assertCount(0, $cart->getItems());
    }

    public function getNonExistentItemIndexes(): array
    {
        return [
            [PHP_INT_MIN],
            [-1],
            [ 1],
            [PHP_INT_MAX],
        ];
    }

    private function buildTestProduct1()
    {
        $product = new Product();
        $product
            ->setId(1)
            ->setUnitPrice(15000);

        return $product;
    }

    private function buildTestProduct2()
    {
        $product = new Product();
        $product
            ->setId(2)
            ->setUnitPrice(10000);

        return $product;
    }
}
