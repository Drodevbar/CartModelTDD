<?php

namespace Gwo\Recruitment\Cart\Exception;

class QuantityTooLowException extends \InvalidArgumentException
{
    public function __construct(int $minimumProductQuantity, int $givenQuantity)
    {
        parent::__construct("Given quantity ({$givenQuantity}) is less than
         Product's minimum quantity ({$minimumProductQuantity})");
    }
}
