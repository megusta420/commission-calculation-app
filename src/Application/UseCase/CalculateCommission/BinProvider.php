<?php

namespace App\Application\UseCase\CalculateCommission;

interface BinProvider
{
    public function getCountry(int $bin): string;
}