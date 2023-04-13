<?php

declare(strict_types=1);

namespace App\Domain;

final class Bin
{
    public function __construct(private readonly int $bin)
    {
        $count = strlen((string)$this->bin);

        if ($count < 4 || $count > 6) {
            throw new InvalidBinException();
        }
    }

    public function __toString(): string
    {
        return (string)$this->bin;
    }
}