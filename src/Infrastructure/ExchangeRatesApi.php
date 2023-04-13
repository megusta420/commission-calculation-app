<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\UseCase\CalculateCommission\CurrencyRateProvider;

// TODO this class is example of an implementation, because we have no api key yet so can't pass the auth
final class ExchangeRatesApi implements CurrencyRateProvider
{
    // todo in future could be moved to some AbstractCurrencyRateProvider to implement common things
    private string $url = 'https://api.exchangeratesapi.io/latest/';

    public function get(string $currency): float
    {
        $rates = file_get_contents($this->url);

        if (!$rates ||
            !($rates = json_decode($rates)) ||
            !property_exists($rates->rates, $currency)) {
            throw new CurrencyRateNotFoundException();
        }

        return $rates->rates->${$currency};
    }
}