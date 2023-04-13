<?php

namespace App\Application\UseCase\CalculateCommission;

interface CurrencyRateProvider
{
    public function get(string $currency): float;
}