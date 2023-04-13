<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Exception;
use Throwable;

final class CurrencyRateNotFoundException extends Exception
{
    public function __construct(string $message = "Currency rates not found", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}