<?php

declare(strict_types=1);

namespace App\Domain;

use Exception;
use Throwable;

final class InvalidCurrencyException extends Exception
{
    public function __construct(string $message = "Currency length should be 3", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}