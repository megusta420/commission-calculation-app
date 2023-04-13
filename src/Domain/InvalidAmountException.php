<?php

declare(strict_types=1);

namespace App\Domain;

use Exception;
use Throwable;

final class InvalidAmountException extends Exception
{
    public function __construct(string $message = "Amount should be positive value", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}