<?php

declare(strict_types=1);

namespace App\Domain;

// todo might become an Entity eventually, now it's an aggregate of ValueObjects to follow business invariants
final class Transaction
{
    public function __construct(private readonly Bin      $bin,
                                private readonly Amount   $amount,
                                private readonly Currency $currency)
    {
    }

    public function bin(): Bin
    {
        return $this->bin;
    }

    public function amount(): Amount
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }
}