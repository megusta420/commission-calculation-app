<?php

declare(strict_types=1);

namespace App\Domain;

final class Amount
{
    public function __construct(private float $amount)
    {
        if ($this->amount <= 0) {
            throw new InvalidAmountException();
        }
    }

    public function amount(): float
    {
        return $this->amount;
    }
}