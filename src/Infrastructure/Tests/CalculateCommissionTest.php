<?php

namespace App\Infrastructure\Tests;

use App\Application\UseCase\CalculateCommission\CalculateCommissionCommand;
use App\Application\UseCase\CalculateCommission\CalculateCommissionHandler;
use App\Domain\InvalidAmountException;
use App\Domain\InvalidBinException;
use App\Infrastructure\BinListNetProvider;
use App\Infrastructure\CurrencyRateNotFoundException;
use App\Infrastructure\ExchangeRatesApiMock;
use PHPUnit\Framework\TestCase;

final class CalculateCommissionTest extends TestCase
{
    private CalculateCommissionHandler $calculateCommission;

    public function testEURCommission()
    {
        $this->assertEquals(
            0.81,
            $this->calculateCommission->handle(new CalculateCommissionCommand(516793, 100.5, "USD"))
        );
    }

    public function testNonEURCommission()
    {
        $this->assertEquals(
            0.67,
            $this->calculateCommission->handle(new CalculateCommissionCommand(516793, 100.5, "EUR")),
        );
    }

    public function testInvalidBin()
    {
        $this->expectExceptionObject(new InvalidBinException());
        $this->calculateCommission->handle(new CalculateCommissionCommand(000000, 100.5, "EUR"));
    }

    public function testInvalidBinLength()
    {
        $this->expectExceptionObject(new InvalidBinException());
        $this->calculateCommission->handle(new CalculateCommissionCommand(333, 100.5, "EUR"));
    }

    public function testInvalidAmount()
    {
        $this->expectExceptionObject(new InvalidAmountException());
        $this->calculateCommission->handle(new CalculateCommissionCommand(444444, -5, "EUR"));
    }

    public function testInvalidCurrency()
    {
//        $this->expectExceptionObject(new InvalidCurrencyException());
        $this->expectExceptionObject(new CurrencyRateNotFoundException());
        $this->calculateCommission->handle(new CalculateCommissionCommand(333333, 100.5, "INVALID"));
    }

    protected function setUp(): void
    {
        $this->calculateCommission = new CalculateCommissionHandler(
        // fixme use mock also for BinProvider
            new BinListNetProvider(),
            new ExchangeRatesApiMock()
        );
    }
}
