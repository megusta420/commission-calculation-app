#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use App\Application\UseCase\CalculateCommission\BinProvider;
use App\Application\UseCase\CalculateCommission\CalculateCommissionHandler;
use App\Application\UseCase\CalculateCommission\CurrencyRateProvider;
use App\Infrastructure\BinListNetProvider;
use App\Infrastructure\ExchangeRatesApiMock;
use App\Infrastructure\Symfony\Command\CalculateCommission;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;

// todo use config/services.yaml
$container = new ContainerBuilder();

// setup BinProvider
$container->autowire('app.providers.bin', BinListNetProvider::class)->setPublic(true);
$container->setAlias(BinProvider::class, 'app.providers.bin')->setPublic(true);

// setup CurrencyRateProvider
$container->autowire('app.providers.rates', ExchangeRatesApiMock::class)->setPublic(true);
$container->setAlias(CurrencyRateProvider::class, 'app.providers.rates')->setPublic(true);

$container->autowire('app.handler', CalculateCommissionHandler::class)->setPublic(true);
$container->setAlias(CalculateCommissionHandler::class, 'app.handler');

$container->autowire('app.command', CalculateCommission::class)->setPublic(true);

$container->compile();

/** @var Command $command */
$command = $container->get('app.command');

$application = new Application();

$application->add($command);

$application->setCatchExceptions(true);
$application->setDefaultCommand($command->getName(), true);
$application->run();