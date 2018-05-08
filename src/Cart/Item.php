<?php

namespace Gwo\Recruitment\Cart;

use Gwo\Recruitment\Cart\Exception\QuantityTooLowException;
use Gwo\Recruitment\Entity\Product;

class Item
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        if ($this->validateMinimumProductQuantity($quantity)) {
            $this->quantity = $quantity;
        }
    }

    public function setQuantity(int $quantity) : void
    {
        if ($this->validateMinimumProductQuantity($quantity)) {
            $this->quantity = $quantity;
        }
    }

    public function getTotalPrice() : int
    {
        return $this->quantity * $this->product->getUnitPrice();
    }

    public function getProduct() : Product
    {
        return $this->product;
    }

    public function getQuantity() : int
    {
        return $this->quantity;
    }

    private function validateMinimumProductQuantity(int $givenQuantity) : bool
    {
        if ($givenQuantity < $this->product->getMinimumQuantity()) {
            throw new QuantityTooLowException($this->product->getMinimumQuantity(), $givenQuantity);
        };
        return true;
    }
}
