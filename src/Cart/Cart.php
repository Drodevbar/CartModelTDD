<?php

namespace Gwo\Recruitment\Cart;

use Gwo\Recruitment\Entity\Product;

class Cart implements \Countable
{

    /**
     * @var array
     */
    private $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function addProduct(Product $product, int $quantity) : self
    {
        $item = $this->getItemIfExists($product);
        if ($item) {
            $item->setQuantity($item->getQuantity() + $quantity);
        } else {
            $this->items[] = new Item($product, $quantity);
        }
        return $this;
    }

    public function removeProduct(Product $product) : void
    {
        $productIndex = $this->getProductIndexIfExists($product);
        if ($productIndex !== null) {
            $this->removeItem($productIndex);
        }
    }

    public function setQuantity(Product $product, int $quantity) : void
    {
        $item = $this->getItemIfExists($product);
        if ($item) {
            $item->setQuantity($quantity);
        } else {
            $this->items[] = new Item($product, $quantity);
        }
    }

    public function getItems() : array
    {
        return $this->count();
    }

    public function getTotalPrice() : int
    {
        $totalPrice = 0;
        foreach ($this->items as &$item) {
            $totalPrice += $item->getTotalPrice();
        }
        return $totalPrice;
    }

    public function getItem(int $offset) : Item
    {
        if (array_key_exists($offset, $this->items)) {
            return $this->items[$offset];
        }
        throw new \OutOfBoundsException("Product with given offset ({$offset}) does not exist in the cart");
    }

    public function count() : array
    {
        return $this->items;
    }

    private function getItemIfExists(Product $product) : ?Item
    {
        $productIndex = $this->getProductIndexIfExists($product);

        return ($productIndex !== null) ? ($this->getItem($productIndex)) : null;
    }

    private function getProductIndexIfExists(Product $product) : ?int
    {
        foreach ($this->items as $index => &$item) {
            if ($item->getProduct() === $product) {
                return $index;
            }
        }
        return null;
    }

    private function removeItem(int $productIndex) : void
    {
        unset($this->items[$productIndex]);

        $this->items = array_values($this->items);
    }
}
