<?php

declare(strict_types=1);

namespace App\Application\UseCase\CalculateCommission;

use Exception;
use Throwable;

final class CommissionCalculationException extends Exception
{
    public function __construct(string $message = "Condition to calculate commission was not found", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}