<?php

namespace Gwo\Recruitment\Entity;

class Product
{
    private const DEFAULT_MINIMUM_QUANTITY = 1;

    /**
     * @var int
     */
    private $unitPrice;

    /**
     * @var int
     */
    private $minimumQuantity;

    /**
     * @var int
     */
    private $id;

    public function __construct()
    {
        $this->minimumQuantity = self::DEFAULT_MINIMUM_QUANTITY;
    }

    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    public function setUnitPrice(int $price) : void
    {
        if ($price < 1) {
            throw new \InvalidArgumentException("Unit price can not be less than 1");
        }
        $this->unitPrice = $price;
    }

    public function setMinimumQuantity(int $quantity) : void
    {
        if ($quantity < $this->minimumQuantity) {
            throw new \InvalidArgumentException("Quantity can not be less than {$this->minimumQuantity}");
        }
        $this->minimumQuantity = $quantity;
    }

    public function getUnitPrice() : int
    {
        return $this->unitPrice;
    }

    public function getMinimumQuantity() : int
    {
        return $this->minimumQuantity;
    }
}
