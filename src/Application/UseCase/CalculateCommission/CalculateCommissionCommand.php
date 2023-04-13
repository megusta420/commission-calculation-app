<?php

declare(strict_types=1);

namespace App\Application\UseCase\CalculateCommission;

final class CalculateCommissionCommand
{
    public function __construct(private readonly int    $bin,
                                private readonly float  $amount,
                                private readonly string $currency)
    {
    }

    public function bin(): int
    {
        return $this->bin;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }
}