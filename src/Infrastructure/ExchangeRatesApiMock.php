<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\UseCase\CalculateCommission\CurrencyRateProvider;

// TODO this class is mock analogue of ExchangeRatesApi where we have no auth key, thus can't get the rates list
final class ExchangeRatesApiMock implements CurrencyRateProvider
{
    // sample data from api response of https://exchangeratesapi.io/documentation/
    private const RATES = [
        "success" => true,
        "timestamp" => 1519296206,
        "base" => "EUR",
        "date" => "2021-03-17",
        "rates" => [
            "AUD" => 1.566015,
            "CAD" => 1.560132,
            "CHF" => 1.154727,
            "CNY" => 7.827874,
            "GBP" => 0.882047,
            "JPY" => 132.360679,
            "USD" => 1.23396,
            "EUR" => 1.5,
        ]
    ];

    public function get(string $currency): float
    {
        if (!key_exists($currency, self::RATES['rates'])) {
            throw new CurrencyRateNotFoundException();
        }

        return self::RATES['rates'][$currency];
    }
}