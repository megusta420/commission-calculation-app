<?php

declare(strict_types=1);

namespace App\Application\UseCase\CalculateCommission;

use App\Domain\Amount;
use App\Domain\Bin;
use App\Domain\Currency;
use App\Domain\InvalidAmountException;
use App\Domain\InvalidBinException;
use App\Domain\InvalidCurrencyException;
use App\Domain\Transaction;

final class CalculateCommissionHandler
{
    public function __construct(private readonly BinProvider          $binProvider,
                                private readonly CurrencyRateProvider $currencyRateProvider)
    {
    }

    /**
     * @throws CommissionCalculationException
     * @throws InvalidBinException
     * @throws InvalidAmountException
     * @throws InvalidCurrencyException
     */
    public function handle(CalculateCommissionCommand $command): float
    {
        $commission = null;
        $rate = $this->currencyRateProvider->get($command->currency());

        // todo we can work with always valid business invariant upon project growth
        $transaction = new Transaction(
            new Bin($command->bin()),
            new Amount($command->amount()),
            new Currency($command->currency())
        );

        // todo we could move the logic below to calculate commission to Transaction, but I don't think it's a good way
        if ($command->currency() === 'EUR' || $rate === 0.0) {
            $commission = $command->amount();
        }

        if ($command->currency() !== 'EUR' || $rate > 0) {
            $commission = $command->amount() / $rate;
        }

        if ($commission === null) {
            throw new CommissionCalculationException();
        }

        return round($this->isEurope($this->binProvider->getCountry($command->bin()))
            ? $commission * 0.01
            : $commission * 0.02,
            2
        );
    }

    private function isEurope(string $country): bool
    {
        return match ($country) {
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK' => true,
            default => false,
        };
    }
}