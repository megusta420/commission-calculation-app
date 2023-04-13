<?php

declare(strict_types=1);

namespace App\Domain;

final class Currency
{

    public function __construct(private readonly string $currency)
    {
        if (strlen($this->currency) !== 3) {
            throw new InvalidCurrencyException();
        }
    }
}